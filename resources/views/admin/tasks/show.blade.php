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
                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                        class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteTaskModal">
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

 {{-- Status Updates Log --}}
<div class="card shadow-sm mt-4">

    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-chat-left-text me-1"></i>
            Progress Updates ({{ $task->statusUpdates->count() }})
        </span>
    </div>

    {{-- Existing Updates --}}
    <div class="card-body p-0">
        @forelse($task->statusUpdates->sortByDesc('created_at') as $update)

            <div class="d-flex gap-3 px-4 py-3 border-bottom">
                <div class="flex-shrink-0">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                         style="width:38px; height:38px; font-size:0.85rem; font-weight:600;">
                        {{ strtoupper(substr($update->user->name, 0, 1)) }}
                    </div>
                </div>

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="fw-semibold">{{ $update->user->name }}</span>
                            <span class="text-muted small ms-2">
                                {{ $update->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Delete button -->
                        <button type="button"
                                class="btn btn-sm btn-link text-danger p-0"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $update->id }}">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>

                    <p class="mb-0 mt-1">{{ $update->content }}</p>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal{{ $update->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">

                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Delete Update</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            Are you sure you want to delete this update?
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                            <form action="{{ route('status-updates.destroy', [$task, $update]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        @empty
            <div class="text-center text-muted py-4">
                No updates yet. Post the first one below.
            </div>
        @endforelse
    </div>

    {{-- Post New Update Form --}}
    <div class="card-footer bg-light">

        @if(session('success') && str_contains(session('success'), 'Update'))
            <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('status-updates.store', $task) }}" method="POST">
            @csrf

            <div class="mb-2">
                <label for="content" class="form-label fw-semibold">Post an Update</label>
                <textarea name="content" id="content" rows="3"
                          class="form-control @error('content') is-invalid @enderror"
                          placeholder="Describe progress...">{{ old('content') }}</textarea>

                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-1"></i> Post Update
            </button>
        </form>
    </div>

</div>

<!-- Task Delete Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1">
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
                <p class="fw-semibold mb-1">Delete this task?</p>
                <small class="text-muted">All updates will also be deleted.</small>
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

</div>
@endsection