@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">Edit Role: <span class="text-muted">{{ $role->name }}</span></h1>
    </div>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">

            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $role->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i> Update Role
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection