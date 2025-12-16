<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalRegistrations;
    public $todayCount;
    public $weekCount;
    public $monthCount;
    public $recentRegistrations;

    public function mount()
    {
        $this->loadStats();
    }

    /**
     * Load dashboard statistics
     */
    public function loadStats()
    {
        $agentId = Auth::id();

        // Total registrations by this agent
        $this->totalRegistrations = Member::where('registered_by', $agentId)->count();

        // Today's registrations
        $this->todayCount = Member::where('registered_by', $agentId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // This week's registrations
        $this->weekCount = Member::where('registered_by', $agentId)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // This month's registrations
        $this->monthCount = Member::where('registered_by', $agentId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Recent registrations (last 10)
        $this->recentRegistrations = Member::where('registered_by', $agentId)
            ->with('constituency')
            ->latest()
            ->take(10)
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
        return view('livewire.agent.dashboard');
    }
}
