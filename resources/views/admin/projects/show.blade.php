@extends('layouts.app')

@section('title', 'Project Detail')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">{{ $project->name }}</h1>
        <span class="badge {{ $project->statusBadgeClass() }} ms-3 fs-6">
            {{ \App\Models\Project::STATUSES[$project->status] }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Project Info --}}
    <div class="card shadow-sm mb-4" style="max-width: 700px;">
        <div class="card-header fw-semibold">
            <i class="bi bi-folder me-1"></i> Project Information
        </div>
        <div class="card-body">
            <p class="mb-2">
                <strong>Manager:</strong> {{ $project->manager->name }}
                <small class="text-muted">({{ $project->manager->email }})</small>
            </p>
            <p class="mb-2">
                <strong>Due Date:</strong>
                @if($project->due_date)
                    <span class="{{ $project->due_date->isPast() && $project->status !== 'completed' ? 'text-danger fw-semibold' : '' }}">
                        {{ $project->due_date->format('F d, Y') }}
                        @if($project->due_date->isPast() && $project->status !== 'completed')
                            <span class="badge bg-danger ms-1">Overdue</span>
                        @endif
                    </span>
                @else
                    <span class="text-muted">No due date set</span>
                @endif
            </p>
            @if($project->description)
                <hr>
                <p class="mb-0 text-muted">{{ $project->description }}</p>
            @endif
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                  onsubmit="return confirm('Delete this project and all its tasks?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Tasks in this Project --}}
    <div class="card shadow-sm">
        <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-check2-square me-1"></i> Tasks ({{ $project->tasks->count() }})</span>
            <a href="{{ route('admin.tasks.create', ['project_id' => $project->id]) }}"
               class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Task
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->tasks as $task)
                        <tr>
                            <td class="fw-semibold">{{ $task->title }}</td>
                            <td>
                                <span class="badge {{ $task->priorityBadgeClass() }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $task->statusBadgeClass() }}">
                                    {{ \App\Models\Task::STATUSES[$task->status] }}
                                </span>
                            </td>
                            <td>{{ $task->assignedTo->name ?? '—' }}</td>
                            <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.tasks.show', $task) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No tasks yet. <a href="{{ route('admin.tasks.create', ['project_id' => $project->id]) }}">Add the first task</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer text-muted small mt-1">
        Created: {{ $project->created_at->format('M d, Y H:i') }} &nbsp;|&nbsp;
        Updated: {{ $project->updated_at->format('M d, Y H:i') }}
    </div>

</div>
@endsection