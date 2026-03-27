<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatusUpdate;
use App\Models\Task;
use Illuminate\Http\Request;

class StatusUpdateController extends Controller
{
    /**
     * Store a new status update for a task.
     * Redirects back to the task detail page.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $task->statusUpdates()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Update posted.');
    }

    /**
     * Delete a specific status update.
     * Redirects back to the task detail page.
     */
    public function destroy(Task $task, StatusUpdate $update)
    {
        // Ensure the update belongs to this task (prevents cross-task deletion)
        abort_if($update->task_id !== $task->id, 404);

        $update->delete();

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Update deleted.');
    }
}