<?php

namespace Database\Seeders;

use App\Models\StatusUpdate;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class StatusUpdateSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();
        $users = User::all();

        if ($tasks->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No tasks or users found. Run TaskSeeder first.');
            return;
        }

        $sampleNotes = [
            'Started working on this. Initial setup complete.',
            'Ran into a blocker — waiting on clarification from the team.',
            'Blocker resolved. Back on track.',
            'Completed the first draft. Ready for review.',
            'Reviewed and approved. Moving to done.',
            'Found a regression — reopening for a fix.',
            'Quick update: about 50% done.',
            'Pair programming session helped unblock this.',
            'Waiting for design assets before continuing.',
            'This is taking longer than expected due to complexity.',
        ];

        $created = 0;
        foreach ($tasks->random(min(8, $tasks->count())) as $task) {
            $numUpdates = rand(1, 3);
            for ($i = 0; $i < $numUpdates; $i++) {
                StatusUpdate::create([
                    'task_id' => $task->id,
                    'user_id' => $users->random()->id,
                    'content' => $sampleNotes[array_rand($sampleNotes)],
                ]);
                $created++;
            }
        }

        $this->command->info($created . ' sample status updates created.');
    }
}