<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company;
use App\Models\User;
use App\Models\Constituency;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditLog;

class ManageCompanies extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingCompanyId;

    // Form fields
    public $name;
    public $email;
    public $phone;
    public $address;
    public $is_active = true;

    // Admin fields (for new company)
    public $admin_name;
    public $admin_email;
    public $admin_phone;
    public $admin_password;
    public $admin_password_confirmation;

    // Constituency assignment
    public $selectedConstituencies = [];

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:companies,email'],
            'phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:companies,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'unique:users,email'],
            'admin_phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:users,phone'],
            'admin_password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    protected $messages = [
        'phone.regex' => 'Phone number must be in Kenyan format (e.g., 0712345678 or +254712345678)',
        'admin_phone.regex' => 'Phone number must be in Kenyan format (e.g., 0712345678 or +254712345678)',
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
     * Create new company with admin
     */
    public function createCompany()
    {
        $this->validate();

        try {
            // Create company
            $company = Company::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'is_active' => $this->is_active,
            ]);

            // Create company admin
            $admin = User::create([
                'company_id' => $company->id,
                'name' => $this->admin_name,
                'email' => $this->admin_email,
                'phone' => $this->admin_phone,
                'password' => Hash::make($this->admin_password),
                'is_active' => true,
            ]);

            $admin->assignRole('Company Admin');

            // Sync constituencies
            if (!empty($this->selectedConstituencies)) {
                $company->constituencies()->sync($this->selectedConstituencies);
            }

            // Log the action
            AuditLog::log('company_created', $company, null, $company->toArray());

            session()->flash('success', 'Company and admin created successfully!');
            $this->closeCreateModal();
            $this->resetPage();

        } catch (\Exception $e) {
            $this->addError('create', 'Failed to create company: ' . $e->getMessage());
        }
    }

    /**
     * Open edit modal
     */
    public function openEditModal($companyId)
    {
        $company = Company::with('constituencies')->findOrFail($companyId);

        $this->editingCompanyId = $companyId;
        $this->name = $company->name;
        $this->email = $company->email;
        $this->phone = $company->phone;
        $this->address = $company->address;
        $this->is_active = $company->is_active;
        $this->selectedConstituencies = $company->constituencies->pluck('id')->toArray();

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
     * Update company
     */
    public function updateCompany()
    {
        $company = Company::findOrFail($this->editingCompanyId);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:companies,email,' . $this->editingCompanyId],
            'phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:companies,phone,' . $this->editingCompanyId],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];

        $this->validate($rules);

        try {
            $oldData = $company->toArray();

            $company->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'is_active' => $this->is_active,
            ]);

            // Sync constituencies
            $company->constituencies()->sync($this->selectedConstituencies);

            // Log the action
            AuditLog::log('company_updated', $company, $oldData, $company->fresh()->toArray());

            session()->flash('success', 'Company updated successfully!');
            $this->closeEditModal();

        } catch (\Exception $e) {
            $this->addError('update', 'Failed to update company: ' . $e->getMessage());
        }
    }

    /**
     * Toggle company active status
     */
    public function toggleStatus($companyId)
    {
        $company = Company::findOrFail($companyId);

        $oldData = $company->toArray();
        $company->update(['is_active' => !$company->is_active]);

        // Log the action
        AuditLog::log('company_status_changed', $company, $oldData, $company->fresh()->toArray());

        $status = $company->is_active ? 'activated' : 'suspended';
        session()->flash('success', "Company {$status} successfully!");
    }

    /**
     * Reset form
     */
    protected function resetForm()
    {
        $this->reset([
            'name',
            'email',
            'phone',
            'address',
            'is_active',
            'admin_name',
            'admin_email',
            'admin_phone',
            'admin_password',
            'admin_password_confirmation',
            'editingCompanyId',
            'selectedConstituencies',
        ]);
        $this->is_active = true;
    }

    /**
     * Render the component
     */
    public function render()
    {
        $companies = Company::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->with([
                'constituencies',
                'agents' => function ($query) {
                    $query->withCount('registeredMembers');
                }
            ])
            ->withCount(['users', 'members'])
            ->latest()
            ->paginate(20);

        $constituencies = Constituency::orderBy('county')->orderBy('name')->get();

        return view('livewire.super-admin.manage-companies', [
            'companies' => $companies,
            'constituencies' => $constituencies,
        ]);
    }
}
