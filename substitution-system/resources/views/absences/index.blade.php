@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">
            <i class="fas fa-user-clock me-2"></i> Manage Absences
        </h1>
        <a href="{{ route('absences.create') }}" class="btn btn-gradient fw-semibold px-3">
            <i class="fas fa-plus-circle me-2"></i> Add Absence
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Absences Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center fw-semibold">
                        <th>Teacher</th>
                        <th>Class</th>
                        <th>Date Range</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absences as $groupKey => $group)
                        @php
                            $teacher = $group->first()->teacher;
                            $department = $teacher->department ?? '-';
                            $dates = $group->pluck('date')->sort();
                            $start = \Carbon\Carbon::parse($dates->first())->format('M d, Y');
                            $end = \Carbon\Carbon::parse($dates->last())->format('M d, Y');
                            $reason = $group->first()->reason;
                            $firstId = $group->first()->id;
                        @endphp
                        <tr class="text-center">
                            <td class="fw-medium">{{ $teacher->name ?? '-' }}</td>
                            <td>{{ $department }}</td>
                            <td>{{ $start }} <span class="text-muted">to</span> {{ $end }}</td>
                            <td><span class="badge bg-warning text-dark px-3 py-2 rounded-pill">{{ $reason }}</span></td>
                            <td>
                                <a href="{{ route('absences.edit', $firstId) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('absences.destroy', $firstId) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this absence record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No absences recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

/* Table Hover Effect */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

/* Rounded Card */
.card {
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Buttons */
.btn-outline-primary:hover {
    background-color: #0d6efd;
    color: #fff;
}
.btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
}
</style>
@endsection
