<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class ManageAgents extends Component
{
    use WithPagination;

    public $search = '';
    public $companyFilter = '';

    protected $queryString = ['search', 'companyFilter'];

    /**
     * Reset pagination when search changes
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when company filter changes
     */
    public function updatingCompanyFilter()
    {
        $this->resetPage();
    }

    /**
     * Clear search
     */
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Clear company filter
     */
    public function clearCompanyFilter()
    {
        $this->companyFilter = '';
        $this->resetPage();
    }

    /**
     * Toggle agent active status
     */
    public function toggleStatus($agentId)
    {
        $agent = User::role('Agent')->findOrFail($agentId);
        $agent->update(['is_active' => !$agent->is_active]);

        $status = $agent->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Agent {$status} successfully!");
    }

    /**
     * Render the component
     */
    public function render()
    {
        $agents = User::role('Agent')
            ->with(['company'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->companyFilter, function ($query) {
                $query->where('company_id', $this->companyFilter);
            })
            ->withCount('registeredMembers')
            ->latest()
            ->paginate(20);

        // Get all companies for filter dropdown
        $companies = \App\Models\Company::orderBy('name')->get();

        return view('livewire.super-admin.manage-agents', [
            'agents' => $agents,
            'companies' => $companies,
        ]);
    }
}
