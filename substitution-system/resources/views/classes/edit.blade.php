@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="fas fa-edit me-2"></i> Edit Class
        </h1>
        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary fw-semibold px-3">
            <i class="fas fa-arrow-left me-2"></i> Back to List
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('classes.update', $class->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Class Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Class Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control form-control-lg shadow-sm rounded-3" 
                           placeholder="Enter class name"
                           value="{{ old('name', $class->name) }}" 
                           required>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <input type="text" 
                           name="description" 
                           id="description" 
                           class="form-control form-control-lg shadow-sm rounded-3" 
                           placeholder="Enter description (optional)"
                           value="{{ old('description', $class->description) }}">
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-gradient px-4 me-2 fw-semibold">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                    <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ======= STYLES ======= --}}
<style>
/* Gradient Button */
.btn-gradient {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
    border: none;
    color: #fff !important;
    transition: all 0.3s ease;
    border-radius: 0.5rem;
}
.btn-gradient:hover {
    background: linear-gradient(135deg, #6610f2, #0d6efd);
    transform: translateY(-1px);
}

/* Form Controls */
.form-control:focus {
    border-color: #6610f2;
    box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
}

/* Card */
.card {
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}
</style>
@endsection
