@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">Create New Role</h1>
    </div>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g. admin, manager, customer">
                    <div class="form-text">Lowercase letters only. Spaces will be converted to underscores.</div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="What can this role do?">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Create Role
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection