@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h2 class="fw-bold mb-1">Welcome Back!</h2>
<p class="text-muted mb-4">Here's an overview of your tasks</p>

<div class="row g-4">

    <!-- Today -->
    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100 {{ $todayTasks ? 'cursor-pointer hover-shadow' : 'opacity-50' }}"
             @if($todayTasks)
                onclick="window.location='{{ route('admin.tasks.index', ['filter' => 'today']) }}'"
             @endif
             style="transition:0.2s;">
            
            <div class="d-flex justify-content-between">
                <span>Today</span>
                <i class="bi bi-calendar"></i>
            </div>

            <h2 class="fw-bold mt-3">
                {{ $todayTasks }}
            </h2>

            <small class="text-muted">Tasks due today</small>
        </div>
    </div>

    <!-- Overdue -->
    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100 {{ $overdueTasks ? 'cursor-pointer hover-shadow' : 'opacity-50' }}"
             @if($overdueTasks)
                onclick="window.location='{{ route('admin.tasks.index', ['filter' => 'overdue']) }}'"
             @endif
             style="transition:0.2s;">
            
            <div class="d-flex justify-content-between">
                <span>Overdue</span>
                <i class="bi bi-exclamation-circle text-danger"></i>
            </div>

            <h2 class="fw-bold mt-3 text-danger">
                {{ $overdueTasks }}
            </h2>

            <small class="text-muted">Tasks overdue</small>
        </div>
    </div>

    <!-- Upcoming -->
    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100 {{ $upcomingTasks ? 'cursor-pointer hover-shadow' : 'opacity-50' }}"
             @if($upcomingTasks)
                onclick="window.location='{{ route('admin.tasks.index', ['filter' => 'upcoming']) }}'"
             @endif
             style="transition:0.2s;">
            
            <div class="d-flex justify-content-between">
                <span>Upcoming</span>
                <i class="bi bi-clock"></i>
            </div>

            <h2 class="fw-bold mt-3">
                {{ $upcomingTasks }}
            </h2>

            <small class="text-muted">Tasks upcoming</small>
        </div>
    </div>

</div>



<!-- Progress Section -->
<div class="card shadow-sm mt-4 p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="fw-semibold">
            <i class="bi bi-graph-up me-1"></i> Progress Overview
        </span>
        <span class="text-muted">{{ round($progress) }}%</span>
    </div>

    <!-- Progress Bar -->
    <div class="progress mb-4" style="height: 8px;">
        <div class="progress-bar bg-dark"
             style="width: {{ $progress }}%"></div>
    </div>

    <div class="row text-center">

        <!-- Total Tasks (CLICKABLE) -->
        <div class="col">
            <a href="{{ route('admin.tasks.index') }}" class="text-decoration-none text-dark">
                <small class="text-muted d-block">Total Tasks</small>
                <h4 class="fw-bold">{{ $totalTasks }}</h4>
            </a>
        </div>

        <!-- Completed (CLICKABLE) -->
        <div class="col">
            <a href="{{ route('admin.tasks.index', ['status' => 'done']) }}" class="text-decoration-none text-success">
                <small class="text-muted d-block">Completed</small>
                <h4 class="fw-bold text-success">{{ $completedTasks }}</h4>
            </a>
        </div>

        <!-- Projects (CLICKABLE) -->
        <div class="col">
            <a href="{{ route('admin.projects.index') }}" class="text-decoration-none text-dark">
                <small class="text-muted d-block">Projects</small>
                <h4 class="fw-bold">{{ $totalProjects }}</h4>
            </a>
        </div>

    </div>

</div>

@endsection