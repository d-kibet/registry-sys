<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates the initial Super Admin user
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'id_number' => '00000000',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'name' => 'Super Admin',
            'email' => 'admin@udaregistry.ke',
            'phone' => '0780222690',
            'password' => Hash::make('0000'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('Super Admin');

        $this->command->info('Super Admin created successfully!');
        $this->command->info('ID Number: 00000000');
        $this->command->info('PIN: 0000');
        $this->command->warn('Please change this PIN after first login!');
    }
}
