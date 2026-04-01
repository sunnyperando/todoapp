@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> New Project
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.projects.index') }}" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Search by name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary w-100">
                <i class="bi bi-search me-1"></i> Filter
            </button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>

    {{-- Projects Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Owner</th>
                        <th>Due Date</th>
                        <th>Tasks</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td class="fw-semibold">{{ $project->name }}</td>
                            <td>
                                <span class="badge {{ $project->statusBadgeClass() }}">
                                    {{ \App\Models\Project::STATUSES[$project->status] }}
                                </span>
                            </td>
                            <td>{{ $project->owner->name ?? '—' }}</td>
                            <td>
                                @if($project->due_date)
                                    <span class="{{ $project->due_date->isPast() ? 'text-danger fw-semibold' : '' }}">
                                        {{ $project->due_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $project->tasks_count ?? $project->tasks->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.projects.show', $project) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                <button type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteProjectModal{{ $project->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <div class="modal fade" id="deleteProjectModal{{ $project->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Project</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="fw-semibold">{{ $project->name }}</p>
                <small class="text-muted">All tasks will also be deleted.</small>
            </div>

            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
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
                            <td colspan="6" class="text-center text-muted py-4">
                                No projects found. <a href="{{ route('admin.projects.create') }}">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $projects->links() }}
    </div>

</div>
@endsection