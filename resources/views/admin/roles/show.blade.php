@extends('layouts.app')

@section('title', 'Role Detail')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">Role: <span class="text-muted">{{ $role->name }}</span></h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Role Info --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">Role Information</div>
        <div class="card-body">
            <p><strong>Name:</strong> <span class="badge bg-secondary text-uppercase">{{ $role->name }}</span></p>
            <p class="mb-0"><strong>Description:</strong> {{ $role->description ?? 'No description provided.' }}</p>
        </div>
    </div>

    {{-- Users with this role --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">
            Users with this Role ({{ $role->users->count() }})
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($role->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->pivot->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                No users assigned to this role yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Assign Role to a User --}}
    <div class="card shadow-sm" style="max-width: 500px;">
        <div class="card-header fw-semibold">Assign This Role to a User</div>
        <div class="card-body">
            <form action="{{ route('admin.users.assignRole', ['user' => '__USER_ID__']) }}"
                  method="POST" id="assignForm">
                @csrf

                <div class="mb-3">
                    <label for="user_id" class="form-label">Select User</label>
                    <select name="user_id" id="user_id" class="form-select" required
                            onchange="updateFormAction(this)">
                        <option value="">-- Choose a user --</option>
                        @foreach($allUsers as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>

                <p class="text-muted small">
                    This will assign the <strong>{{ $role->name }}</strong> role to the selected user.
                    To manage multiple roles for a user at once, go to the user's detail page.
                </p>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i> Assign Role
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function updateFormAction(select) {
    const userId = select.value;
    const form = document.getElementById('assignForm');
    form.action = `/admin/users/${userId}/assign-roles`;
}
</script>
@endsection