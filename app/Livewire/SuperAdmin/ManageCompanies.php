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
    public $showAdminsModal = false;
    public $editingCompanyId;
    public $managingCompanyId;

    // Form fields
    public $name;
    public $phone;
    public $address;
    public $is_active = true;

    // Admin fields (for new company)
    public $admin_id_number;
    public $admin_first_name;
    public $admin_second_name;
    public $admin_last_name;
    public $admin_phone;
    public $admin_pin;
    public $admin_pin_confirmation;

    // Constituency assignment
    public $selectedConstituencies = [];

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:companies,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'admin_id_number' => ['required', 'string', 'regex:/^\d{7,8}$/', 'unique:users,id_number'],
            'admin_first_name' => ['required', 'string', 'max:255'],
            'admin_second_name' => ['nullable', 'string', 'max:255'],
            'admin_last_name' => ['required', 'string', 'max:255'],
            'admin_phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:users,phone'],
            'admin_pin' => ['required', 'digits_between:4,6', 'confirmed'],
        ];
    }

    protected $messages = [
        'phone.regex' => 'Phone number must be in Kenyan format (e.g., 0712345678 or +254712345678)',
        'admin_phone.regex' => 'Phone number must be in Kenyan format (e.g., 0712345678 or +254712345678)',
        'admin_id_number.regex' => 'ID number must be 7 or 8 digits',
        'admin_pin.digits_between' => 'PIN must be between 4 and 6 digits',
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
                'phone' => $this->phone,
                'address' => $this->address,
                'is_active' => $this->is_active,
            ]);

            // Create company admin
            // Build full name from name parts
            $fullName = trim(implode(' ', array_filter([
                $this->admin_first_name,
                $this->admin_second_name,
                $this->admin_last_name
            ])));

            $admin = User::create([
                'company_id' => $company->id,
                'id_number' => $this->admin_id_number,
                'first_name' => $this->admin_first_name,
                'second_name' => $this->admin_second_name,
                'last_name' => $this->admin_last_name,
                'name' => $fullName,
                'email' => null,
                'phone' => $this->admin_phone,
                'password' => Hash::make($this->admin_pin),
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
            'phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:companies,phone,' . $this->editingCompanyId],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];

        $this->validate($rules);

        try {
            $oldData = $company->toArray();

            $company->update([
                'name' => $this->name,
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
     * Open manage admins modal
     */
    public function openAdminsModal($companyId)
    {
        $this->managingCompanyId = $companyId;
        $this->resetAdminFields();
        $this->showAdminsModal = true;
    }

    /**
     * Close manage admins modal
     */
    public function closeAdminsModal()
    {
        $this->showAdminsModal = false;
        $this->managingCompanyId = null;
        $this->resetAdminFields();
        $this->resetValidation();
    }

    /**
     * Add new admin to company
     */
    public function addAdmin()
    {
        $company = Company::findOrFail($this->managingCompanyId);

        // Validate only admin fields
        $rules = [
            'admin_id_number' => ['required', 'string', 'regex:/^\d{7,8}$/', 'unique:users,id_number'],
            'admin_first_name' => ['required', 'string', 'max:255'],
            'admin_second_name' => ['nullable', 'string', 'max:255'],
            'admin_last_name' => ['required', 'string', 'max:255'],
            'admin_phone' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:users,phone'],
            'admin_pin' => ['required', 'digits_between:4,6', 'confirmed'],
        ];

        $this->validate($rules);

        try {
            // Build full name from name parts
            $fullName = trim(implode(' ', array_filter([
                $this->admin_first_name,
                $this->admin_second_name,
                $this->admin_last_name
            ])));

            $admin = User::create([
                'company_id' => $company->id,
                'id_number' => $this->admin_id_number,
                'first_name' => $this->admin_first_name,
                'second_name' => $this->admin_second_name,
                'last_name' => $this->admin_last_name,
                'name' => $fullName,
                'email' => null,
                'phone' => $this->admin_phone,
                'password' => Hash::make($this->admin_pin),
                'is_active' => true,
            ]);

            $admin->assignRole('Company Admin');

            // Log the action
            AuditLog::log('admin_created', $admin, null, $admin->toArray());

            session()->flash('success', 'Admin added successfully!');
            $this->resetAdminFields();
            $this->resetValidation();

        } catch (\Exception $e) {
            $this->addError('add_admin', 'Failed to add admin: ' . $e->getMessage());
        }
    }

    /**
     * Toggle admin active status
     */
    public function toggleAdminStatus($adminId)
    {
        $admin = User::findOrFail($adminId);

        $oldData = $admin->toArray();
        $admin->update(['is_active' => !$admin->is_active]);

        // Log the action
        AuditLog::log('admin_status_changed', $admin, $oldData, $admin->fresh()->toArray());

        $status = $admin->is_active ? 'activated' : 'suspended';
        session()->flash('success', "Admin {$status} successfully!");
    }

    /**
     * Reset admin fields only
     */
    protected function resetAdminFields()
    {
        $this->reset([
            'admin_id_number',
            'admin_first_name',
            'admin_second_name',
            'admin_last_name',
            'admin_phone',
            'admin_pin',
            'admin_pin_confirmation',
        ]);
    }

    /**
     * Reset form
     */
    protected function resetForm()
    {
        $this->reset([
            'name',
            'phone',
            'address',
            'is_active',
            'admin_id_number',
            'admin_first_name',
            'admin_second_name',
            'admin_last_name',
            'admin_phone',
            'admin_pin',
            'admin_pin_confirmation',
            'editingCompanyId',
            'managingCompanyId',
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

        // Load company admins if managing admins
        $managingCompany = null;
        $companyAdmins = [];
        if ($this->managingCompanyId) {
            $managingCompany = Company::with(['admins' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->findOrFail($this->managingCompanyId);
            $companyAdmins = $managingCompany->admins;
        }

        return view('livewire.super-admin.manage-companies', [
            'companies' => $companies,
            'constituencies' => $constituencies,
            'managingCompany' => $managingCompany,
            'companyAdmins' => $companyAdmins,
        ]);
    }
}
