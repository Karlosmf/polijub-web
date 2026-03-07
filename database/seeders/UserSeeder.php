<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin is already in AdminUserSeeder, but we can add more if needed
        User::factory()->create([
            'name' => 'John Manager',
            'email' => 'manager@test.com',
            'role' => UserRole::MANAGER,
        ]);

        User::factory()->create([
            'name' => 'Jane Cashier',
            'email' => 'cashier@test.com',
            'role' => UserRole::CASHIER,
        ]);

        User::factory()->create([
            'name' => 'Bob Employee',
            'email' => 'employee@test.com',
            'role' => UserRole::EMPLOYEE,
        ]);

        User::factory()->count(10)->create([
            'role' => UserRole::CUSTOMER,
        ]);

        User::factory()->create([
            'name' => 'Main Franchise',
            'email' => 'franchise@test.com',
            'role' => UserRole::FRANCHISE,
        ]);
    }
}
