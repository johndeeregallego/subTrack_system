@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fas fa-book me-2"></i> Add Subject & Room Assignment
        </div>
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-2 text-danger"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Subject Name & Section</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           placeholder="e.g., MIL-HUMSS-8" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label fw-semibold">Room Assignment</label>
                    <input type="text" name="code" id="code" class="form-control" 
                           placeholder="e.g., RM 14-11 (3rd Flr.)" value="{{ old('code') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description (Optional)</label>
                    <textarea name="description" id="description" class="form-control" 
                              rows="3" placeholder="Enter short description...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary fw-semibold">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-gradient fw-semibold">
                        <i class="fas fa-save me-1"></i> Save Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.btn-gradient {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
    color: #fff;
    border: none;
}
.btn-gradient:hover {
    background: linear-gradient(135deg, #6610f2, #0d6efd);
}
</style>
@endsection
