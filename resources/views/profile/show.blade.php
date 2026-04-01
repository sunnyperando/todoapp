@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container" style="max-width:700px;">

    <div class="card shadow-sm">
        <div class="card-body text-center">

            {{-- Avatar --}}
            <div class="mb-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                     style="width:80px;height:80px;font-size:1.8rem;font-weight:600;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>

            {{-- Name --}}
            <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>

            {{-- Email --}}
            <p class="text-muted mb-3">{{ Auth::user()->email }}</p>

            <hr>

            {{-- Info --}}
            <div class="text-start">
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Phone:</strong> {{ auth()->user()->phone ?? '—' }}</p>
                <p><strong>User ID:</strong> {{ Auth::user()->id }}</p>
                <p><strong>Joined:</strong> {{ Auth::user()->created_at->format('F d, Y') }}</p>
            </div>

            {{-- Actions --}}
            <div class="mt-4 d-flex gap-2 justify-content-center">
                <!-- Edit Button -->
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>

                <!-- Delete Button 
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash me-1"></i> Delete Account
                </button> -->

                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    Back to Dashboard
                </a>
            </div>

        </div>
    </div>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5>Edit Profile</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ auth()->user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ auth()->user()->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ auth()->user()->phone }}">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save Changes</button>
                </div>

            </form>

        </div>
    </div>
</div>

</div>

@endsection
