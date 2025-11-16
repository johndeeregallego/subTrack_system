@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-exchange-alt me-2"></i> Substitutions
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('substitutions.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Add Substitution
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-2">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- Bulk delete form --}}
    <form id="bulk-delete-form" action="{{ route('substitutions.bulkDelete') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">

                @php
                    // Group substitutions by absent teacher name
                    $groupedSubs = $substitutions->groupBy(function($item) {
                        return $item->teacher->name ?? 'N/A';
                    });

                    $bgClasses = ['bg-light', 'bg-white'];
                    $bgIndex = 0;
                @endphp

                @foreach ($groupedSubs as $absentTeacher => $subs)
                    <div class="p-3 {{ $bgClasses[$bgIndex % 2] }} rounded-top">
                        <h5 class="mb-3 text-primary fw-bold">
                            <i class="fas fa-user-slash me-2"></i> Absent Teacher: {{ $absentTeacher }}
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th><input type="checkbox" class="select-all-group"></th>
                                        <th>#</th>
                                        <th>Subject / Room</th>
                                        <th>Substitute Teacher</th>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>Time Slot</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subs as $index => $sub)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $sub->id }}" class="select-item form-check-input">
                                        </td>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            {{ $sub->subject?->name ?? 'VACANT' }}
                                            @if(!empty($sub->subject_room))
                                                / {{ $sub->subject_room }}
                                            @endif
                                        </td>
                                        <td>{{ $sub->substitute->name ?? 'N/A' }}</td>
                                        <td>{{ $sub->date ?? '-' }}</td>
                                        <td>{{ $sub->day ?? '-' }}</td>
                                        <td>{{ $sub->time_slot ?? '-' }}</td>
                                        <td class="text-center d-flex gap-2 justify-content-center">
                                            <a href="{{ route('substitutions.edit', $sub->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-info btn-preview" data-bs-toggle="modal" data-bs-target="#previewModal" 
                                                data-subject="{{ $sub->subject?->name ?? 'VACANT' }}"
                                                data-room="{{ $sub->subject_room ?? '' }}"
                                                data-substitute="{{ $sub->substitute->name ?? 'N/A' }}"
                                                data-date="{{ $sub->date ?? '-' }}"
                                                data-day="{{ $sub->day ?? '-' }}"
                                                data-time="{{ $sub->time_slot ?? '-' }}"
                                                data-absent="{{ $absentTeacher }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @php $bgIndex++; @endphp
                @endforeach

            </div>
        </div>

        {{-- Bulk delete button --}}
        <div class="mt-3 d-flex justify-content-end">
            <button type="submit" id="bulk-delete-btn" class="btn btn-danger shadow-sm" disabled>
                <i class="fas fa-trash-alt me-1"></i> Delete Selected
            </button>
        </div>
    </form>
</div>

{{-- Preview Modal --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-primary">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="previewModalLabel">Substitution Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Absent Teacher:</strong> <span id="modalAbsentTeacher"></span></p>
        <p><strong>Subject / Room:</strong> <span id="modalSubjectRoom"></span></p>
        <p><strong>Substitute Teacher:</strong> <span id="modalSubstituteTeacher"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Day:</strong> <span id="modalDay"></span></p>
        <p><strong>Time Slot:</strong> <span id="modalTimeSlot"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkForm = document.getElementById('bulk-delete-form');

    // Select all group checkboxes
    document.querySelectorAll('.select-all-group').forEach(selectAllGroup => {
        selectAllGroup.addEventListener('change', function() {
            const tableBody = this.closest('div').querySelector('tbody');
            if (!tableBody) return;

            tableBody.querySelectorAll('.select-item').forEach(cb => {
                cb.checked = this.checked;
            });
            updateBulkDeleteButton();
        });
    });

    // Enable/disable bulk delete button dynamically
    bulkForm.querySelectorAll('.select-item').forEach(item => {
        item.addEventListener('change', updateBulkDeleteButton);
    });

    function updateBulkDeleteButton() {
        const anyChecked = [...bulkForm.querySelectorAll('.select-item')].some(cb => cb.checked);
        bulkDeleteBtn.disabled = !anyChecked;
    }

    // Confirm before bulk delete
    bulkForm.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to delete selected substitutions?')) {
            e.preventDefault();
        }
    });

    // Preview modal data fill
    document.querySelectorAll('.btn-preview').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modalAbsentTeacher').textContent = this.dataset.absent;
            const subject = this.dataset.subject;
            const room = this.dataset.room;
            document.getElementById('modalSubjectRoom').textContent = subject + (room ? ' / ' + room : '');
            document.getElementById('modalSubstituteTeacher').textContent = this.dataset.substitute;
            document.getElementById('modalDate').textContent = this.dataset.date;
            document.getElementById('modalDay').textContent = this.dataset.day;
            document.getElementById('modalTimeSlot').textContent = this.dataset.time;
        });
    });
});
</script>

<style>
.bg-light {
    background-color: #f8f9fa !important;
}
.bg-white {
    background-color: #ffffff !important;
}
</style>
@endsection
