@extends('layouts.app')

@section('title', 'Task Detail')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">{{ $task->title }}</h1>
        <span class="badge {{ $task->statusBadgeClass() }} ms-3 fs-6">
            {{ \App\Models\Task::STATUSES[$task->status] }}
        </span>
        <span class="badge {{ $task->priorityBadgeClass() }} ms-2 fs-6">
            {{ ucfirst($task->priority) }} Priority
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Task Info --}}
        <div class="col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    <i class="bi bi-card-text me-1"></i> Task Details
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Project:</strong>
                        <a href="{{ route('admin.projects.show', $task->project) }}" class="text-decoration-none">
                            {{ $task->project->name }}
                        </a>
                    </p>
                    <p class="mb-2">
                        <strong>Assigned To:</strong> {{ $task->assignedTo->name ?? '—' }}
                        @if($task->assignedTo)
                            <small class="text-muted">({{ $task->assignedTo->email }})</small>
                        @endif
                    </p>
                    <p class="mb-2">
                        <strong>Created By:</strong> {{ $task->createdBy->name ?? '—' }}
                    </p>
                    <p class="mb-2">
                        <strong>Due Date:</strong>
                        @if($task->due_date)
                            <span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-danger fw-semibold' : '' }}">
                                {{ $task->due_date->format('F d, Y') }}
                                @if($task->due_date->isPast() && $task->status !== 'done')
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @endif
                            </span>
                        @else
                            <span class="text-muted">No due date</span>
                        @endif
                    </p>
                    @if($task->description)
                        <hr>
                        <p class="text-muted mb-0">{{ $task->description }}</p>
                    @endif
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Metadata --}}
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    <i class="bi bi-info-circle me-1"></i> Metadata
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Created:</strong>
                        {{ $task->created_at->format('M d, Y H:i') }}
                    </p>
                    <p class="mb-0">
                        <strong>Last Updated:</strong>
                        {{ $task->updated_at->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
         STATUS UPDATES LOG — Added in Part 6
         After completing Part 6, the StatusUpdate section will appear
         below this comment block.
         ============================================================ --}}

</div>
@endsection