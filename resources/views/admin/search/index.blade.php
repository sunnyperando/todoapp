@extends('layouts.app')

@section('title', 'Search Results')

@section('content')

<h4 class="fw-bold mb-3">Search Results for "{{ $query }}"</h4>

{{-- PROJECTS --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">Projects</div>
    <div class="card-body">
        @forelse($projects as $project)
            <div>
                <a href="{{ route('admin.projects.show', $project) }}">
                    {{ $project->name }}
                </a>
            </div>
        @empty
            <p class="text-muted">No projects found</p>
        @endforelse
    </div>
</div>

{{-- TASKS --}}
<div class="card">
    <div class="card-header fw-semibold">Tasks</div>
    <div class="card-body">
        @forelse($tasks as $task)
            <div>
                <a href="{{ route('admin.tasks.show', $task) }}">
                    {{ $task->title }}
                </a>
            </div>
        @empty
            <p class="text-muted">No tasks found</p>
        @endforelse
    </div>
</div>

@endsection