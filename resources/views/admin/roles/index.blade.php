@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Roles Management</h1>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Users</th>
                        <th>Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td>{{ $role->description ?? '—' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $role->users_count }} user(s)
                                </span>
                            </td>
                            <td>{{ $role->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.roles.show', $role) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No roles found. <a href="{{ route('admin.roles.create') }}">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $roles->links() }}
    </div>

</div>
@endsection