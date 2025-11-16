@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="fas fa-chalkboard me-2"></i> Manage Classes
        </h1>
        <a href="{{ route('classes.create') }}" class="btn btn-gradient fw-semibold px-4">
            <i class="fas fa-plus me-2"></i> Add Class
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Classes Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Section</th>
                            <th>Room</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                            <tr>
                                <td class="fw-semibold">{{ $class->id }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->description ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this class?');">
                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i>No classes found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ======= STYLES ======= --}}
<style>
/* Page Layout */
h1 {
    font-size: 1.8rem;
}

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

/* Card */
.card {
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Table */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s;
}

/* Buttons */
.btn-outline-primary:hover, .btn-outline-danger:hover {
    color: #fff !important;
}
.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
}
</style>
@endsection
