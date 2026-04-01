@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container text-center mt-5">

    <h1 class="fw-bold mb-3"><i class="bi bi-kanban-fill me-2"></i> TaskFlow</h1>
    <p class="lead mb-4">A Laravel Personal Task Management App</p>

    <div class="mb-4">
        <p><strong>Project:</strong> TaskFlow - Personal Todo App</p>
        <p><strong>Created by:</strong> Sunny Lorenz Perando</p>
        <p><strong>Goal:</strong> Help users stay organized, track tasks, and manage projects efficiently.</p>
    </div>
    </br> </br> </br>
    <div class="mb-5">
        <h5 class="fw-semibold">What problem does this solve?</h5>
        <p class="text-muted" style="max-width:600px; margin:auto;">
            Many people struggle to keep track of their daily tasks, deadlines, and responsibilities.
            TaskFlow solves this by providing a simple and organized system where users can manage
            their tasks, monitor progress, and stay productive without feeling overwhelmed.
        </p>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('login') }}" class="btn btn-primary px-4">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4">Register</a>
    </div>

</div>
@endsection