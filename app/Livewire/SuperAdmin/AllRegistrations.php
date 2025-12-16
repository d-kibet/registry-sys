<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use App\Models\Company;
use App\Models\Constituency;

class AllRegistrations extends Component
{
    use WithPagination;

    public $search = '';
    public $companyFilter = '';
    public $constituencyFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 20;

    protected $queryString = ['search', 'companyFilter', 'constituencyFilter'];

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCompanyFilter()
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
        $this->reset(['search', 'companyFilter', 'constituencyFilter', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    /**
     * Render the component
     */
    public function render()
    {
        $members = Member::with(['registeredBy', 'company', 'constituency'])
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->companyFilter, function ($query) {
                $query->where('company_id', $this->companyFilter);
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

        // Get companies for filter dropdown (cached for 6 hours)
        $companies = \Illuminate\Support\Facades\Cache::remember('companies.active', now()->addHours(6), function () {
            return Company::where('is_active', true)->orderBy('name')->get();
        });

        // Get constituencies for filter dropdown (cached for 1 day)
        $constituencies = \Illuminate\Support\Facades\Cache::remember('constituencies.all', now()->addDay(), function () {
            return Constituency::orderBy('county')->orderBy('name')->get();
        });

        return view('livewire.super-admin.all-registrations', [
            'members' => $members,
            'companies' => $companies,
            'constituencies' => $constituencies,
        ]);
    }
}
