@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Roles Page Working ✅</h1>

    @foreach($roles as $role)
        <p>{{ $role->name }}</p>
    @endforeach
</div>
@endsection