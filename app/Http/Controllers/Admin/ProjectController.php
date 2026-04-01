<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
    {
        /**
         * Display all projects with optional status filter.
         */
        public function index(Request $request)
    {
        $query = Project::with('owner');

        // Personal user → only own projects
        if (!auth()->user()->isAdmin()) {
            $query->where('created_by', auth()->id());
        }

        // Optional search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $projects = $query->latest()->paginate(10);

        $statuses = Project::STATUSES;

        return view('admin.projects.index', compact('projects', 'statuses'));
    }

    /**
     * Show the form to create a new project.
     */
    public function create()
    {
        $managers = User::orderBy('name')->get();
        $statuses = Project::STATUSES;
        return view('admin.projects.create', compact('managers', 'statuses'));
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:' . implode(',', array_keys(Project::STATUSES))],
            'due_date'    => ['nullable', 'date', 'after_or_equal:today'],
            // 'manager_id'  => ['required', 'exists:users,id'],
        ]);

        $validated['created_by'] = auth()->id();

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display a single project and its tasks.
     */
    public function show(Project $project)
    {
        // Restrict access (personal mode)
        if (!auth()->user()->isAdmin()) {
            if ($project->created_by !== auth()->id()) {
                abort(403);
            }
        }

        // Load tasks + assigned users
        $project->load(['tasks.assignedTo', 'owner']);

        return view('admin.projects.show', compact('project'));

    }

    /**
     * Show the form to edit a project.
     */
    public function edit(Project $project)
    {
        $managers = User::orderBy('name')->get();
        $statuses = Project::STATUSES;
        return view('admin.projects.edit', compact('project', 'managers', 'statuses'));
    }

    /**
     * Update an existing project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:' . implode(',', array_keys(Project::STATUSES))],
            'due_date'    => ['nullable', 'date'],
            'manager_id'  => ['required', 'exists:users,id'],
        ]);

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Delete a project (tasks cascade-delete automatically).
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project "' . $project->name . '" deleted.');
    }
}