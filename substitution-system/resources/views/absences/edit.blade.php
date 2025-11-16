@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="fas fa-user-edit me-2"></i> Edit Absence
        </h1>
        <a href="{{ route('absences.index') }}" class="btn btn-outline-secondary fw-semibold">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2 text-danger"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <form action="{{ route('absences.update', $absence->id) }}" method="POST" class="card shadow-sm border-0 p-4 rounded-4">
        @csrf
        @method('PUT')

        {{-- Teacher --}}
        <div class="mb-4">
            <label for="teacher_id" class="form-label fw-semibold">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select select-enhanced" required>
                <option value="">-- Select Teacher --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $absence->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date --}}
        <div class="mb-4">
            <label for="date" class="form-label fw-semibold">Date of Absence</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $absence->date) }}" required>
            </div>
        </div>

        {{-- Reason --}}
        <div class="mb-4">
            <label for="reason" class="form-label fw-semibold">Reason</label>
            <input type="text" name="reason" id="reason" class="form-control" placeholder="Enter reason for absence"
                   value="{{ old('reason', $absence->reason) }}">
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('absences.index') }}" class="btn btn-outline-secondary fw-semibold">Cancel</a>
            <button type="submit" class="btn btn-gradient fw-semibold">Update Absence</button>
        </div>
    </form>
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

/* Select focus style */
.select-enhanced:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25);
}

/* Card & Shadow */
.card {
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Form inputs */
.form-label {
    color: #333;
}
</style>
@endsection
