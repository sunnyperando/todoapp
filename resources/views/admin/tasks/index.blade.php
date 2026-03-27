@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tasks</h1>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> New Task
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.tasks.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="project_id" class="form-select">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}"
                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="priority" class="form-select">
                <option value="">All Priorities</option>
                @foreach($priorities as $key => $label)
                    <option value="{{ $key }}" {{ request('priority') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="assigned_to" class="form-select">
                <option value="">All Assignees</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary w-100">
                <i class="bi bi-search me-1"></i> Filter
            </button>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>

    {{-- Tasks Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td class="fw-semibold">{{ $task->title }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $task->project) }}"
                                   class="text-decoration-none text-muted small">
                                    {{ $task->project->name }}
                                </a>
                            </td>
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
                            <td>
                                @if($task->due_date)
                                    <span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-danger fw-semibold' : 'text-muted' }}">
                                        {{ $task->due_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.tasks.show', $task) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.tasks.edit', $task) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.tasks.destroy', $task) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
<button type="button"
        class="btn btn-danger btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#deleteTaskModal{{ $task->id }}">
    <i class="bi bi-trash"></i>
</button>

<div class="modal fade" id="deleteTaskModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Delete Task
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="fw-semibold mb-1">{{ $task->title }}</p>
                <small class="text-muted">This cannot be undone.</small>
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No tasks found. <a href="{{ route('admin.tasks.create') }}">Add the first one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $tasks->links() }}
    </div>



</div>
@endsection