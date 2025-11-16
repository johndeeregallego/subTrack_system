@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="fas fa-chalkboard-teacher me-2"></i> Teachers
        </h1>
        <a href="{{ route('teachers.create') }}" class="btn btn-gradient fw-semibold">
            <i class="fas fa-plus me-1"></i> Add New Teacher
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Teachers Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Available</th>
                        <th>Absent</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr class="text-center">
                            <td class="fw-semibold">{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->department ?? '—' }}</td>
                            <td>
                                @if($teacher->is_available)
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Yes</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">No</span>
                                @endif
                            </td>
                            <td>
                                @if($teacher->is_absent)
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Yes</span>
                                @else
                                    <span class="badge bg-success px-3 py-2 rounded-pill">No</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> No teachers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ======= STYLES ======= --}}
<style>
/* Gradient Add Button */
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

/* Card Design */
.card {
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Table Hover */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
