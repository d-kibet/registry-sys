<?php

namespace App\Livewire\CompanyAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditLog;

class ManageAgents extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingAgentId;

    // Form fields
    public $id_number;
    public $first_name;
    public $second_name;
    public $last_name;
    public $phone;
    public $pin;
    public $pin_confirmation;
    public $is_active = true;

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'id_number' => ['required', 'numeric', 'unique:users,id_number'],
            'first_name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:users,phone'],
            'pin' => ['required', 'numeric', 'digits:4', 'confirmed'],
            'is_active' => ['boolean'],
        ];
    }

    protected $messages = [
        'phone.regex' => 'Phone number must be in Kenyan format (e.g., 0712345678 or +254712345678)',
        'pin.digits' => 'PIN must be exactly 4 digits',
        'pin.confirmed' => 'PIN confirmation does not match',
    ];

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
     * Open create modal
     */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    /**
     * Close create modal
     */
    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    /**
     * Create new agent
     */
    public function createAgent()
    {
        $this->validate();

        try {
            // Combine name fields for the name column
            $fullName = trim($this->first_name . ' ' . ($this->second_name ?? '') . ' ' . $this->last_name);

            $agent = User::create([
                'company_id' => Auth::user()->company_id,
                'id_number' => $this->id_number,
                'first_name' => $this->first_name,
                'second_name' => $this->second_name,
                'last_name' => $this->last_name,
                'name' => $fullName,
                'phone' => $this->phone,
                'password' => Hash::make($this->pin),
                'is_active' => $this->is_active,
            ]);

            $agent->assignRole('Agent');

            // Log the action
            AuditLog::log('agent_created', $agent, null, $agent->toArray());

            session()->flash('success', 'Agent created successfully!');
            $this->closeCreateModal();
            $this->resetPage();

        } catch (\Exception $e) {
            $this->addError('create', 'Failed to create agent: ' . $e->getMessage());
        }
    }

    /**
     * Open edit modal
     */
    public function openEditModal($agentId)
    {
        $agent = User::findOrFail($agentId);

        // Verify agent belongs to this company
        if ($agent->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $this->editingAgentId = $agentId;
        $this->id_number = $agent->id_number;
        $this->first_name = $agent->first_name;
        $this->second_name = $agent->second_name;
        $this->last_name = $agent->last_name;
        $this->phone = $agent->phone;
        $this->is_active = $agent->is_active;

        $this->showEditModal = true;
    }

    /**
     * Close edit modal
     */
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    /**
     * Update agent
     */
    public function updateAgent()
    {
        $agent = User::findOrFail($this->editingAgentId);

        // Verify agent belongs to this company
        if ($agent->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $rules = [
            'id_number' => ['required', 'numeric', 'unique:users,id_number,' . $this->editingAgentId],
            'first_name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:users,phone,' . $this->editingAgentId],
            'is_active' => ['boolean'],
        ];

        // If PIN is provided, validate it
        if (!empty($this->pin)) {
            $rules['pin'] = ['required', 'numeric', 'digits:4', 'confirmed'];
        }

        $this->validate($rules);

        try {
            $oldData = $agent->toArray();

            // Combine name fields for the name column
            $fullName = trim($this->first_name . ' ' . ($this->second_name ?? '') . ' ' . $this->last_name);

            $updateData = [
                'id_number' => $this->id_number,
                'first_name' => $this->first_name,
                'second_name' => $this->second_name,
                'last_name' => $this->last_name,
                'name' => $fullName,
                'phone' => $this->phone,
                'is_active' => $this->is_active,
            ];

            // Only update PIN if provided
            if (!empty($this->pin)) {
                $updateData['password'] = Hash::make($this->pin);
            }

            $agent->update($updateData);

            // Log the action
            AuditLog::log('agent_updated', $agent, $oldData, $agent->fresh()->toArray());

            session()->flash('success', 'Agent updated successfully!');
            $this->closeEditModal();

        } catch (\Exception $e) {
            $this->addError('update', 'Failed to update agent: ' . $e->getMessage());
        }
    }

    /**
     * Toggle agent active status
     */
    public function toggleStatus($agentId)
    {
        $agent = User::findOrFail($agentId);

        // Verify agent belongs to this company
        if ($agent->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $oldData = $agent->toArray();
        $agent->update(['is_active' => !$agent->is_active]);

        // Log the action
        AuditLog::log('agent_status_changed', $agent, $oldData, $agent->fresh()->toArray());

        $status = $agent->is_active ? 'activated' : 'suspended';
        session()->flash('success', "Agent {$status} successfully!");
    }

    /**
     * Reset form
     */
    protected function resetForm()
    {
        $this->reset([
            'id_number',
            'first_name',
            'second_name',
            'last_name',
            'phone',
            'pin',
            'pin_confirmation',
            'is_active',
            'editingAgentId',
        ]);
        $this->is_active = true;
    }

    /**
     * Render the component
     */
    public function render()
    {
        $companyId = Auth::user()->company_id;

        $agents = User::where('company_id', $companyId)
            ->role('Agent')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('id_number', 'like', "%{$this->search}%")
                        ->orWhere('first_name', 'like', "%{$this->search}%")
                        ->orWhere('second_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%")
                        ->orWhere('name', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->withCount('registeredMembers')
            ->latest()
            ->paginate(20);

        return view('livewire.company-admin.manage-agents', [
            'agents' => $agents,
        ]);
    }
}
