@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center fw-bold mb-5 text-primary">
        <i class="fas fa-exchange-alt me-2"></i> Edit Substitution
    </h1>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-2 mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2 text-danger"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('substitutions.update', $substitution->id) }}" method="POST" class="card shadow-sm border-0 rounded-2 p-4 mx-auto" style="max-width: 950px;">
        @csrf
        @method('PUT')

        {{-- Absent Teacher --}}
        <div class="mb-3">
            <label for="absence_id" class="form-label fw-semibold">
                <i class="fas fa-user-slash me-2 text-primary"></i> Original Teacher (Absent)
            </label>
            <select name="absence_id" id="absence_id" class="form-select" required>
                <option value="">-- Select Absent Teacher --</option>
                @foreach($absentTeachers as $teacher)
                    @foreach($teacher->absences as $absence)
                        <option value="{{ $absence->id }}"
                                data-department="{{ $teacher->department }}"
                                data-start="{{ \Carbon\Carbon::parse($absence->created_at)->format('M d, Y') }}"
                                data-end="{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}"
                                data-day="{{ \Carbon\Carbon::parse($absence->date)->format('l') }}"
                                {{ $substitution->absence_id == $absence->id ? 'selected' : '' }}>
                            {{ $teacher->name }} ({{ \Carbon\Carbon::parse($absence->created_at)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }})
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>

        {{-- Auto-filled info --}}
        <div class="row mb-3 g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Start Date</label>
                <input type="text" id="start_date" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($substitution->absence->created_at)->format('M d, Y') }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">End Date</label>
                <input type="text" id="end_date" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($substitution->absence->date)->format('M d, Y') }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Day</label>
                <input type="text" id="day" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($substitution->absence->date)->format('l') }}" readonly>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Class / Department</label>
            <input type="text" id="class_department" class="form-control bg-light" value="{{ $substitution->teacher->department }}" readonly>
        </div>

        {{-- Substitute table --}}
        <h5 class="fw-bold mb-3 text-secondary">
            <i class="fas fa-clock me-2"></i> Assign Substitute Teacher for Time Slot
        </h5>

        <div class="table-responsive mb-3">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Time Slot</th>
                        <th>Substitute Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{ $substitution->time_slot }}
                            <input type="hidden" name="time_slots[]" value="{{ $substitution->time_slot }}">
                        </td>
                        <td>
                            <select name="substitute_ids[]" class="form-select" data-slot="{{ $substitution->time_slot }}" required>
                                <option value="">-- Select Substitute --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $substitution->substitute_id == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('substitutions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Substitution
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const absenceSelect = document.getElementById('absence_id');
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');
    const dayInput = document.getElementById('day');
    const classInput = document.getElementById('class_department');
    const dropdowns = document.querySelectorAll('select[data-slot]');

    absenceSelect.addEventListener('change', function() {
        const opt = absenceSelect.selectedOptions[0];
        if (!opt) return;

        startInput.value = opt.dataset.start || '';
        endInput.value = opt.dataset.end || '';
        dayInput.value = opt.dataset.day || '';
        classInput.value = opt.dataset.department || '';

        const day = opt.dataset.day;
        if (!day) return;

        dropdowns.forEach(dd => {
            const slot = dd.dataset.slot;
            fetch(`/substitutions/available-teachers?day=${encodeURIComponent(day)}&time_slot=${encodeURIComponent(slot)}`)
                .then(res => res.json())
                .then(data => {
                    dd.innerHTML = '<option value="">-- Select Substitute --</option>';
                    data.forEach(t => {
                        const option = document.createElement('option');
                        option.value = t.id;
                        option.textContent = t.name;
                        dd.appendChild(option);
                    });
                }).catch(err => {
                    console.error(err);
                    dd.innerHTML = '<option disabled>Error loading teachers</option>';
                });
        });
    });
});
</script>
@endsection
