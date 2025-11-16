@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="fas fa-user-edit me-2"></i> Edit Teacher
        </h1>
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <strong><i class="fas fa-exclamation-circle me-1"></i> Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control form-control-lg rounded-3"
                        value="{{ old('name', $teacher->name) }}" placeholder="Enter teacher name" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg rounded-3"
                        value="{{ old('email', $teacher->email) }}" placeholder="Enter email address" required>
                </div>

                {{-- Classroom --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Classroom</label>
                    <select name="department" class="form-select form-select-lg rounded-3">
                        <option value="">— Select Classroom —</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->description }}"
                                {{ old('department', $teacher->department) == $class->description ? 'selected' : '' }}>
                                {{ $class->description }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold d-block mb-2">Status</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="available" value="available"
                            {{ $teacher->is_available ? 'checked' : '' }}>
                        <label class="form-check-label" for="available">Available</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="absent" value="absent"
                            {{ $teacher->is_absent ? 'checked' : '' }}>
                        <label class="form-check-label" for="absent">Absent</label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary px-4">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="fas fa-save me-1"></i> Update Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ======= STYLES ======= --}}
<style>
/* Gradient Primary Button */
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

/* Card Styling */
.card {
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Form Improvements */
.form-control:focus, .form-select:focus {
    border-color: #6610f2;
    box-shadow: 0 0 0 0.15rem rgba(102,16,242,0.25);
}
</style>
@endsection
