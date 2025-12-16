<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Company Management
            'manage companies',
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            // User/Agent Management
            'manage users',
            'view users',
            'create agents',
            'edit agents',
            'suspend agents',
            'delete users',

            // Member Registration
            'register members',
            'view members',
            'view own registrations',
            'view company registrations',
            'view all registrations',
            'edit members',
            'delete members',
            'export members',
            'import members',

            // Reports & Analytics
            'view reports',
            'view company reports',
            'view own reports',
            'export reports',

            // Audit Logs
            'view audit logs',
            'view company audit logs',

            // System Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - Full platform access
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Company Admin - Manage their company and agents
        $companyAdmin = Role::create(['name' => 'Company Admin']);
        $companyAdmin->givePermissionTo([
            'view users',
            'create agents',
            'edit agents',
            'suspend agents',
            'view members',
            'view company registrations',
            'edit members',
            'export members',
            'import members',
            'view company reports',
            'export reports',
            'view company audit logs',
        ]);

        // Agent - Register members only
        $agent = Role::create(['name' => 'Agent']);
        $agent->givePermissionTo([
            'register members',
            'view own registrations',
            'view own reports',
        ]);
    }
}
