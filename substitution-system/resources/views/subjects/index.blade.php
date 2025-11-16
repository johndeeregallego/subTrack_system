@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">
            <i class="fas fa-book-open me-2"></i>Subjects & Room Assignments
        </h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-gradient fw-semibold">
            <i class="fas fa-plus me-1"></i> Add New Subject
        </a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Subjects Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @if ($subjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th class="text-start ps-4">#</th>
                                <th>Subject Name & Section</th>
                                <th>Room Assignment</th>
                                <th>Description</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $index => $subject)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ $subject->description ?? '—' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('subjects.edit', $subject->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('subjects.destroy', $subject->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No subjects found.</h5>
                    <p class="text-muted small">Click the button above to add your first subject.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Custom Gradient Button Style --}}
<style>
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
