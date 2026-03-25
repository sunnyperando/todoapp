@extends('layouts.app')

@section('title', $user->name)

@section('page-header') @endsection
@section('page-title', 'User Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
@endsection

@section('content')
<div class="row g-4">

    {{-- Profile Card --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                 style="width:72px;height:72px;font-size:1.8rem;font-weight:700">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            <span class="badge bg-success px-3 py-2">Active</span>

            <hr />

            <div class="text-start small text-muted">
                <p class="mb-1">
                    <i class="bi bi-telephone me-2"></i>
                    {{ $user->phone ?? 'No phone provided' }}
                </p>
                <p class="mb-1">
                    <i class="bi bi-calendar3 me-2"></i>
                    Joined {{ $user->created_at->format('M d, Y') }}
                </p>
                <p class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Updated {{ $user->updated_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>

    {{-- Details Panel --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">Account Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted fw-normal w-25">User ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Full Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Phone</th>
                            <td>{{ $user->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Email Verified</th>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">
                                        Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">Not Verified</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Registered</th>
                            <td>{{ $user->created_at->format('F d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Last Updated</th>
                            <td>{{ $user->updated_at->format('F d, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Edit User
            </a>

            <button type="button"
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal">
                <i class="bi bi-trash me-1"></i> Delete User
            </button>

            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list-ul me-1"></i> All Users
            </a>
        </div>
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to permanently delete
                <strong>{{ $user->name }}</strong>?
                This action <span class="text-danger fw-semibold">cannot be undone</span>.
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection