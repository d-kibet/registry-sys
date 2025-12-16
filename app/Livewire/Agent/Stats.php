<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Stats extends Component
{
    public $dailyStats = [];
    public $genderBreakdown = [];
    public $topConstituencies = [];
    public $totalMembers = 0;

    public function mount()
    {
        $this->loadStats();
    }

    /**
     * Load all statistics
     */
    public function loadStats()
    {
        $agentId = Auth::id();

        // Total members
        $this->totalMembers = Member::where('registered_by', $agentId)->count();

        // Daily stats for the last 7 days
        $this->dailyStats = Member::where('registered_by', $agentId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->date)->format('D, M d') => $item->count];
            })
            ->toArray();

        // Fill in missing days with 0
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $key = $date->format('D, M d');
            $days[$key] = $this->dailyStats[$key] ?? 0;
        }
        $this->dailyStats = $days;

        // Gender breakdown
        $this->genderBreakdown = Member::where('registered_by', $agentId)
            ->select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->gender => $item->count];
            })
            ->toArray();

        // Top 5 constituencies
        $this->topConstituencies = Member::where('registered_by', $agentId)
            ->with('constituency')
            ->select('constituency_id', DB::raw('COUNT(*) as count'))
            ->groupBy('constituency_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->constituency->name,
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Refresh statistics
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
        return view('livewire.agent.stats');
    }
}
