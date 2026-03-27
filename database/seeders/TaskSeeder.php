<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $users    = User::all();

        if ($projects->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No projects or users found. Run ProjectSeeder and register users first.');
            return;
        }

        $sampleTasks = [
            ['title' => 'Define project requirements', 'priority' => 'high',   'status' => 'done'],
            ['title' => 'Create wireframes',           'priority' => 'high',   'status' => 'done'],
            ['title' => 'Set up development environment', 'priority' => 'medium', 'status' => 'done'],
            ['title' => 'Design database schema',      'priority' => 'high',   'status' => 'in_progress'],
            ['title' => 'Build authentication module', 'priority' => 'high',   'status' => 'in_progress'],
            ['title' => 'Implement admin dashboard',   'priority' => 'medium', 'status' => 'todo'],
            ['title' => 'Write unit tests',            'priority' => 'medium', 'status' => 'todo'],
            ['title' => 'Conduct user testing',        'priority' => 'low',    'status' => 'todo'],
            ['title' => 'Deploy to staging',           'priority' => 'high',   'status' => 'todo'],
            ['title' => 'Prepare release notes',       'priority' => 'low',    'status' => 'todo'],
        ];

        $created = 0;
        foreach ($projects as $project) {
            // Assign 2–4 tasks per project
            $taskSubset = collect($sampleTasks)->shuffle()->take(rand(2, 4));

            foreach ($taskSubset as $taskData) {
                Task::create([
                    'project_id'  => $project->id,
                    'assigned_to' => $users->random()->id,
                    'created_by'  => $users->random()->id,
                    'title'       => $taskData['title'],
                    'description' => 'Sample task for ' . $project->name . '.',
                    'priority'    => $taskData['priority'],
                    'status'      => $taskData['status'],
                    'due_date'    => now()->addDays(rand(5, 60))->toDateString(),
                ]);
                $created++;
            }
        }

        $this->command->info($created . ' sample tasks created across ' . $projects->count() . ' projects.');
    }
}