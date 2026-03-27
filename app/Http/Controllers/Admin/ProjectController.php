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
        $query = Project::with('manager')->latest();

        if ($request->filled('status') && array_key_exists($request->status, Project::STATUSES)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $projects = $query->paginate(10)->withQueryString();
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
            'manager_id'  => ['required', 'exists:users,id'],
        ]);

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display a single project and its tasks.
     */
    public function show(Project $project)
    {
        $project->load(['manager', 'tasks.assignedTo']);
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