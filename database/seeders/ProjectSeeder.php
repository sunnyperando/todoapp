<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $managers = User::all();

        if ($managers->isEmpty()) {
            $this->command->warn('No users found. Register at least one user first.');
            return;
        }

        $projects = [
            [
                'name'        => 'Website Redesign',
                'description' => 'Rebuild the company website with modern design and improved performance.',
                'status'      => 'active',
                'due_date'    => now()->addDays(45)->toDateString(),
            ],
            [
                'name'        => 'Mobile App v2',
                'description' => 'Second version of the mobile app with offline support and push notifications.',
                'status'      => 'planning',
                'due_date'    => now()->addMonths(3)->toDateString(),
            ],
            [
                'name'        => 'Internal CRM',
                'description' => 'Customer relationship management tool for the sales team.',
                'status'      => 'on_hold',
                'due_date'    => now()->addMonths(6)->toDateString(),
            ],
            [
                'name'        => 'Q1 Marketing Campaign',
                'description' => 'Digital marketing campaign for product launch in Q1.',
                'status'      => 'completed',
                'due_date'    => now()->subDays(10)->toDateString(),
            ],
            [
                'name'        => 'Data Migration',
                'description' => 'Migrate legacy database to new infrastructure with zero downtime.',
                'status'      => 'active',
                'due_date'    => now()->addDays(20)->toDateString(),
            ],
        ];

        foreach ($projects as $data) {
            Project::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['manager_id' => $managers->random()->id])
            );
        }

        $this->command->info(count($projects) . ' sample projects created.');
    }
}