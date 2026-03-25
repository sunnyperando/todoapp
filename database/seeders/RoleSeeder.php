<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'admin',
                'description' => 'Full system access — can manage all modules, users, and settings.',
            ],
            [
                'name'        => 'manager',
                'description' => 'Can create and manage projects and tasks, and assign work to employees.',
            ],
            [
                'name'        => 'employee',
                'description' => 'Can view assigned tasks and post status updates on their own work.',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}