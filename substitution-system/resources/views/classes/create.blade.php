@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header py-2 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #dc3545, #a71d2a);">
                    <h6 class="mb-0 fw-bold text-white">
                        <i class="fas fa-user-times me-2"></i> Add Absence
                    </h6>
                    <a href="{{ route('absences.index') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                {{-- Body --}}
                <div class="card-body bg-light p-3">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-3 small">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-1 mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('absences.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        {{-- Absence Details --}}
                        <div class="mb-3">
                            <h6 class="fw-bold text-danger mb-2">
                                <i class="fas fa-id-card me-1"></i> Absence Details
                            </h6>

                            <div class="row g-2">
                                {{-- Teacher --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark small">Teacher</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-chalkboard-teacher text-danger"></i>
                                        </span>
                                        <select 
                                            name="teacher_id" 
                                            id="teacher_id"
                                            class="form-select form-select-sm @error('teacher_id') is-invalid @enderror" 
                                            required>
                                            <option value="">-- Select Teacher --</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a teacher.</div>
                                    </div>
                                </div>

                                {{-- Class --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark small">Class</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-school text-danger"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            id="department" 
                                            class="form-control form-control-sm bg-light" 
                                            placeholder="Auto-filled based on teacher"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Duration Section --}}
                        <div class="border-top pt-2 mt-3">
                            <h6 class="fw-bold text-danger mb-2">
                                <i class="fas fa-calendar-day me-1"></i> Absence Duration
                            </h6>

                            <div class="row g-2">
                                {{-- Start Date --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark small">Start Date</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-alt text-danger"></i>
                                        </span>
                                        <input 
                                            type="date" 
                                            name="start_date" 
                                            class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date') }}" 
                                            required>
                                        <div class="invalid-feedback">Please provide a start date.</div>
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-dark small">End Date</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-check text-danger"></i>
                                        </span>
                                        <input 
                                            type="date" 
                                            name="end_date" 
                                            class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date') }}" 
                                            required>
                                        <div class="invalid-feedback">Please provide an end date.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Reason Section --}}
                        <div class="border-top pt-2 mt-3">
                            <h6 class="fw-bold text-danger mb-2">
                                <i class="fas fa-comment-dots me-1"></i> Reason for Absence
                            </h6>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-pen text-danger"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="reason" 
                                    class="form-control form-control-sm @error('reason') is-invalid @enderror" 
                                    placeholder="Enter reason for absence"
                                    value="{{ old('reason') }}" 
                                    required>
                                <div class="invalid-feedback">Please enter a reason.</div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm rounded-3">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Auto-Fill Department --}}
<script>
document.getElementById('teacher_id').addEventListener('change', function() {
    const teacherId = this.value;
    const departmentInput = document.getElementById('department');

    if (teacherId) {
        fetch(`/teachers/${teacherId}/department`)
            .then(res => res.json())
            .then(data => departmentInput.value = data.department || 'N/A')
            .catch(() => departmentInput.value = 'N/A');
    } else {
        departmentInput.value = '';
    }
});
</script>

{{-- Bootstrap Validation --}}
<script>
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
@endsection
