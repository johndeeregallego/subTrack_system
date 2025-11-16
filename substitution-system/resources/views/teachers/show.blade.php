@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Teacher Details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">{{ $teacher->name }}</h4>
            <p><strong>Email:</strong> {{ $teacher->email }}</p>
            <p><strong>Department:</strong> {{ $teacher->department ?? '-' }}</p>
            <p><strong>Available:</strong> {{ $teacher->is_available ? 'Yes' : 'No' }}</p>
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
