<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Company;
use App\Models\Constituency;
use App\Models\Member;
use App\Models\User;

class WarmCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up the application cache with frequently accessed data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Warming up application cache...');

        // Cache constituencies list (rarely changes, accessed frequently)
        $this->info('Caching constituencies...');
        Cache::remember('constituencies.all', now()->addDay(), function () {
            return Constituency::orderBy('county')->orderBy('name')->get();
        });

        // Cache active companies
        $this->info('Caching active companies...');
        Cache::remember('companies.active', now()->addHours(6), function () {
            return Company::where('is_active', true)
                ->withCount(['users', 'members'])
                ->orderBy('name')
                ->get();
        });

        // Cache company statistics
        $this->info('Caching company statistics...');
        $companies = Company::all();
        foreach ($companies as $company) {
            Cache::remember("company.{$company->id}.stats", now()->addHours(1), function () use ($company) {
                return [
                    'total_members' => $company->members()->count(),
                    'total_agents' => $company->users()
                        ->whereHas('roles', fn($q) => $q->where('name', 'Agent'))
                        ->count(),
                    'total_admins' => $company->users()
                        ->whereHas('roles', fn($q) => $q->where('name', 'Company Admin'))
                        ->count(),
                    'verified_members' => $company->members()->where('is_verified', true)->count(),
                    'recent_registrations' => $company->members()->where('created_at', '>=', now()->subDays(7))->count(),
                ];
            });
        }

        // Cache global statistics
        $this->info('Caching global statistics...');
        Cache::remember('stats.global', now()->addHours(1), function () {
            return [
                'total_members' => Member::count(),
                'total_companies' => Company::count(),
                'total_agents' => User::whereHas('roles', fn($q) => $q->where('name', 'Agent'))->count(),
                'verified_members' => Member::where('is_verified', true)->count(),
                'recent_registrations' => Member::where('created_at', '>=', now()->subDays(7))->count(),
            ];
        });

        // Cache constituency statistics
        $this->info('Caching constituency statistics...');
        Cache::remember('stats.constituencies', now()->addHours(6), function () {
            return Constituency::withCount('members')->get()->map(function ($constituency) {
                return [
                    'id' => $constituency->id,
                    'name' => $constituency->name,
                    'county' => $constituency->county,
                    'member_count' => $constituency->members_count,
                ];
            });
        });

        $this->info('Cache warming completed successfully!');

        return Command::SUCCESS;
    }
}
