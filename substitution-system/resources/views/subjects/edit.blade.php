@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white fw-bold">
            <i class="fas fa-edit me-2"></i> Edit Subject & Room Assignment
        </div>

        <div class="card-body">
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Subject Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Subject Name & Section <small class="text-muted">(e.g., MIL-HUMSS-8)</small></label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $subject->name) }}" 
                           required>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Room Assignment --}}
                <div class="mb-3">
                    <label for="code" class="form-label">Room Assignment <small class="text-muted">(e.g., RM 14-11 (3rd Flr.))</small></label>
                    <input type="text" 
                           name="code" 
                           id="code" 
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $subject->code) }}" 
                           required>
                    @error('code')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description <small class="text-muted">(optional)</small></label>
                    <textarea name="description" 
                              id="description" 
                              rows="3" 
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Enter short description or remarks">{{ old('description', $subject->description) }}</textarea>
                    @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-gradient fw-semibold">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary fw-semibold">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}
.btn-gradient {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
    color: #fff;
    border: none;
    transition: 0.3s ease;
}
.btn-gradient:hover {
    background: linear-gradient(135deg, #6610f2, #0d6efd);
    color: #fff;
    transform: translateY(-2px);
}
</style>
@endsection
