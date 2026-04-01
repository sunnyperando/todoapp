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

    /* if (!auth()->user()->isAdmin()) {
        $query->where('created_by', auth()->id());
    } */

    if (!auth()->user()->isAdmin()) {
        $query->where(function ($q) {
            $q->where('created_by', auth()->id())
            ->orWhere('assigned_to', auth()->id());
        });
    }

    // SEARCH
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    if ($request->filled('filter')) {

    if ($request->filter === 'today') {
        $query->whereDate('due_date', today());
    }

    if ($request->filter === 'overdue') {
        $query->where('due_date', '<', today())
              ->where('status', '!=', 'done');
    }

    if ($request->filter === 'upcoming') {
        $query->where('due_date', '>', today());
    }
}

    // Filters
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

    // DEFINE THESE BEFORE RETURN
    $tasks      = $query->paginate(15)->withQueryString();
    if (!auth()->user()->isAdmin()) {
        $projects = Project::where('created_by', auth()->id())
            ->orderBy('name')
            ->get();
    } else {
        $projects = Project::orderBy('name')->get();
    }
    $users      = User::orderBy('name')->get();
    $statuses   = Task::STATUSES;
    $priorities = Task::PRIORITIES;

    // RETURN LAST
    return view('admin.tasks.index', compact(
        'tasks', 'projects', 'users', 'statuses', 'priorities'
    ));
}

    /**
     * Show the form to create a new task.
     */
    public function create(Request $request)
    {
        // FIRST: get projects
        if (!auth()->user()->isAdmin()) {
            $projects = Project::where('created_by', auth()->id())->get();
        } else {
            $projects = Project::all();
        }

        // THEN: check if empty
        if ($projects->isEmpty()) {
            return redirect()->route('admin.projects.create')
                ->with('warning', 'Create a project first before adding tasks.');
        }

        // SELECTED PROJECT
        $selectedProjectId = $request->query('project_id');

        // Tasks priority and statuses
        $priorities = Task::PRIORITIES;
        $statuses   = Task::STATUSES;

        // RETURN VIEW
        return view('admin.tasks.create', compact(
            'projects',
            'selectedProjectId',
            'priorities',
            'statuses'
        ));
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => ['required', 'exists:projects,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority'    => ['required', 'in:' . implode(',', array_keys(Task::PRIORITIES))],
            'status'      => ['required', 'in:' . implode(',', array_keys(Task::STATUSES))],
            'due_date'    => ['nullable', 'date'],
        ]);

        if (!auth()->user()->isAdmin()) {
            $project = Project::where('id', $validated['project_id'])
                ->where('created_by', auth()->id())
                ->firstOrFail();
        }

        // Personal app: auto assign to yourself
        $validated['assigned_to'] = auth()->id();
        $validated['created_by']  = auth()->id();

        // CREATE TASK (NOT PROJECT)
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
        /* $task->load(['project', 'assignedTo', 'createdBy', 'statusUpdates.user']); */

        if (!auth()->user()->isAdmin() && $task->created_by !== auth()->id()) {
            abort(403);
        }
        return view('admin.tasks.show', compact('task'));

    }

    /**
     * Show the form to edit a task.
     */
    public function edit(Task $task)
    {   

        if (!auth()->user()->isAdmin() && $task->created_by !== auth()->id()) {
            abort(403);
        }

    if (!auth()->user()->isAdmin()) {
        $projects = Project::where('created_by', auth()->id())
            ->orderBy('name')
            ->get();
    } else {
        if (!auth()->user()->isAdmin()) {
            $projects = Project::where('created_by', auth()->id())
                ->orderBy('name')
                ->get();
        } else {
            $projects = Project::orderBy('name')->get();
        }
    }
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

        if (!auth()->user()->isAdmin() && $task->created_by !== auth()->id()) {
            abort(403);
        }
        
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