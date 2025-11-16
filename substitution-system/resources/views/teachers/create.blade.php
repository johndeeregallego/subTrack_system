@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user-plus me-2"></i> Add New Teacher
                    </h4>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">
                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Create Form --}}
                    <form action="{{ route('teachers.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small text-dark">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name"
                                    class="form-control form-control-sm rounded-3 @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" 
                                    required>
                                @error('name')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small text-dark">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email"
                                    class="form-control form-control-sm rounded-3 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" 
                                    required>
                                @error('email')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Department --}}
                            <div class="col-md-6">
                                <label for="department" class="form-label fw-semibold small text-dark">
                                    Department
                                </label>
                                <input 
                                    type="text" 
                                    id="department" 
                                    name="department"
                                    class="form-control form-control-sm rounded-3 @error('department') is-invalid @enderror"
                                    value="{{ old('department') }}">
                                @error('department')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Class --}}
                            <div class="col-md-6">
                                <label for="class_id" class="form-label fw-semibold small text-dark">
                                    Class Assignment
                                </label>
                                <select 
                                    name="class_id" 
                                    id="class_id"
                                    class="form-select form-select-sm rounded-3 @error('class_id') is-invalid @enderror">
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold small text-dark">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select 
                                    id="status" 
                                    name="status"
                                    class="form-select form-select-sm rounded-3 @error('status') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Status --</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="text-end mt-4">
                            <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm rounded-3">
                                <i class="fas fa-save"></i> Save Teacher
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
