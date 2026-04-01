

@extends('layouts.app')

@section('title', 'New Project')

@section('content')
<div class="container-fluid">

@if(session('warning'))
    <div class="d-flex justify-content-center">
        <div class="alert alert-warning alert-dismissible fade show text-center w-50" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('warning') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0">New Project</h1>
    </div>

    <div class="card shadow-sm" style="max-width: 700px;">
        <div class="card-body">

            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Project Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g. Website Redesign">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="What is this project about?">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status"
                                class="form-select @error('status') is-invalid @enderror">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'planning') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="due_date" class="form-label fw-semibold">Due Date</label>
                        <input type="date" name="due_date" id="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date') }}">
                        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="manager_id" class="form-label fw-semibold">Owner <span class="text-danger">*</span></label>
                    <!-- select name="manager_id" id="manager_id"
                            class="form-select @error('manager_id') is-invalid @enderror">
                        <option value="">-- Select Manager --</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }} ({{ $manager->email }})
                        </option>
                        @endforeach>
                    </select -->

                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    <input type="hidden" name="created_by" value="{{ Auth::id() }}">

                    @error('manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Create Project
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection