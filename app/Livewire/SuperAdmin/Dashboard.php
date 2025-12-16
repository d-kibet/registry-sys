<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use App\Models\Member;
use App\Models\User;
use App\Models\Company;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalCompanies;
    public $totalAgents;
    public $totalRegistrations;
    public $todayCount;
    public $weekCount;
    public $monthCount;
    public $recentRegistrations;
    public $topCompanies;

    public function mount()
    {
        $this->loadStats();
    }

    /**
     * Load dashboard statistics
     */
    public function loadStats()
    {
        // Total companies
        $this->totalCompanies = Company::where('is_active', true)->count();

        // Total agents across all companies
        $this->totalAgents = User::role('Agent')
            ->where('is_active', true)
            ->count();

        // Total registrations
        $this->totalRegistrations = Member::count();

        // Today's registrations
        $this->todayCount = Member::whereDate('created_at', Carbon::today())->count();

        // This week's registrations
        $this->weekCount = Member::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // This month's registrations
        $this->monthCount = Member::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Recent registrations (last 10)
        $this->recentRegistrations = Member::with(['registeredBy', 'company', 'constituency'])
            ->latest()
            ->take(10)
            ->get();

        // Top 5 performing companies
        $this->topCompanies = Company::withCount('members')
            ->orderByDesc('members_count')
            ->limit(5)
            ->get();
    }

    /**
     * Refresh stats
     */
    public function refresh()
    {
        $this->loadStats();
        $this->dispatch('stats-refreshed');
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.super-admin.dashboard');
    }
}
