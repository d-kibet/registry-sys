<?php

namespace App\Livewire\CompanyAdmin;

use Livewire\Component;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalRegistrations;
    public $totalAgents;
    public $todayCount;
    public $weekCount;
    public $monthCount;
    public $recentRegistrations;
    public $topAgents;

    public function mount()
    {
        $this->loadStats();
    }

    /**
     * Load dashboard statistics
     */
    public function loadStats()
    {
        $companyId = Auth::user()->company_id;

        // Total registrations for this company
        $this->totalRegistrations = Member::where('company_id', $companyId)->count();

        // Total active agents in this company
        $this->totalAgents = User::where('company_id', $companyId)
            ->role('Agent')
            ->where('is_active', true)
            ->count();

        // Today's registrations
        $this->todayCount = Member::where('company_id', $companyId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // This week's registrations
        $this->weekCount = Member::where('company_id', $companyId)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // This month's registrations
        $this->monthCount = Member::where('company_id', $companyId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Recent registrations (last 10)
        $this->recentRegistrations = Member::where('company_id', $companyId)
            ->with(['registeredBy', 'constituency'])
            ->latest()
            ->take(10)
            ->get();

        // Top 5 performing agents
        $this->topAgents = User::where('company_id', $companyId)
            ->role('Agent')
            ->withCount('registeredMembers')
            ->orderByDesc('registered_members_count')
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
        return view('livewire.company-admin.dashboard');
    }
}
