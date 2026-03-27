<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display all tasks with optional filters.
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedTo'])->latest();

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status') && array_key_exists($request->status, Task::STATUSES)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && array_key_exists($request->priority, Task::PRIORITIES)) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks    = $query->paginate(15)->withQueryString();
        $projects = Project::orderBy('name')->get();
        $users    = User::orderBy('name')->get();
        $statuses   = Task::STATUSES;
        $priorities = Task::PRIORITIES;

        return view('admin.tasks.index', compact('tasks', 'projects', 'users', 'statuses', 'priorities'));
    }

    /**
     * Show the form to create a new task.
     */
    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $users    = User::orderBy('name')->get();
        $statuses   = Task::STATUSES;
        $priorities = Task::PRIORITIES;

        // Pre-select project if passed from the project show page
        $selectedProjectId = $request->query('project_id');

        return view('admin.tasks.create', compact('projects', 'users', 'statuses', 'priorities', 'selectedProjectId'));
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => ['required', 'exists:projects,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority'    => ['required', 'in:' . implode(',', array_keys(Task::PRIORITIES))],
            'status'      => ['required', 'in:' . implode(',', array_keys(Task::STATUSES))],
            'due_date'    => ['nullable', 'date'],
        ]);

        $validated['created_by'] = auth()->id();

        Task::create($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display a single task with its status updates.
     * Status updates log is rendered here — see Part 6.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'assignedTo', 'createdBy', 'statusUpdates.user']);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form to edit a task.
     */
    public function edit(Task $task)
    {
        $projects = Project::orderBy('name')->get();
        $users    = User::orderBy('name')->get();
        $statuses   = Task::STATUSES;
        $priorities = Task::PRIORITIES;
        return view('admin.tasks.edit', compact('task', 'projects', 'users', 'statuses', 'priorities'));
    }

    /**
     * Update an existing task.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id'  => ['required', 'exists:projects,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority'    => ['required', 'in:' . implode(',', array_keys(Task::PRIORITIES))],
            'status'      => ['required', 'in:' . implode(',', array_keys(Task::STATUSES))],
            'due_date'    => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a task (status updates cascade-delete automatically).
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted.');
    }
}