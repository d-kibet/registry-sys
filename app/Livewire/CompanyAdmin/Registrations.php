<?php

namespace App\Livewire\CompanyAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class Registrations extends Component
{
    use WithPagination;

    public $search = '';
    public $agentFilter = '';
    public $constituencyFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 20;

    protected $queryString = ['search', 'agentFilter', 'constituencyFilter'];

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAgentFilter()
    {
        $this->resetPage();
    }

    public function updatingConstituencyFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    /**
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->reset(['search', 'agentFilter', 'constituencyFilter', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    /**
     * Render the component
     */
    public function render()
    {
        $companyId = Auth::user()->company_id;

        $members = Member::where('company_id', $companyId)
            ->with(['registeredBy', 'constituency'])
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->agentFilter, function ($query) {
                $query->where('registered_by', $this->agentFilter);
            })
            ->when($this->constituencyFilter, function ($query) {
                $query->where('constituency_id', $this->constituencyFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->latest()
            ->paginate($this->perPage);

        // Get agents for filter dropdown (cached for 1 hour per company)
        $agents = \Illuminate\Support\Facades\Cache::remember("company.{$companyId}.agents", now()->addHour(), function () use ($companyId) {
            return \App\Models\User::where('company_id', $companyId)
                ->whereHas('roles', fn($q) => $q->where('name', 'Agent'))
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        });

        // Get constituencies for filter dropdown (cached for 1 day)
        $constituencies = \Illuminate\Support\Facades\Cache::remember('constituencies.all', now()->addDay(), function () {
            return \App\Models\Constituency::orderBy('county')->orderBy('name')->get();
        });

        return view('livewire.company-admin.registrations', [
            'members' => $members,
            'agents' => $agents,
            'constituencies' => $constituencies,
        ]);
    }
}
