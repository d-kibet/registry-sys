<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MyRegistrations extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 20;

    protected $queryString = ['search'];

    /**
     * Reset pagination when search changes
     */
    public function updatingSearch()
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
     * Render the component
     */
    public function render()
    {
        $agentId = Auth::id();

        $members = Member::where('registered_by', $agentId)
            ->with(['constituency'])
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.agent.my-registrations', [
            'members' => $members,
        ]);
    }
}
