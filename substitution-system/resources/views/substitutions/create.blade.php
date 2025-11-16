@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Page Heading --}}
    <h1 class="text-center fw-bold mb-5 text-primary">
        <i class="fas fa-calendar-alt me-2"></i> Create Substitution Schedule
    </h1>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3 mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2 text-danger"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('substitutions.store') }}" method="POST" class="card shadow-sm border-0 rounded-3 p-4 mx-auto" style="max-width: 950px;">
        @csrf

        {{-- Hidden input for teacher_id and date --}}
        <input type="hidden" name="teacher_id" id="teacher_id">
        <input type="hidden" name="date" id="date"> {{-- ✅ Added this line --}}

        {{-- Absent Teacher --}}
        <div class="mb-4">
            <label for="absence_id" class="form-label fw-semibold">
                <i class="fas fa-user-slash me-2 text-primary"></i> Original Teacher (Absent)
            </label>
            <select name="absence_id" id="absence_id" class="form-select shadow-sm" required>
                <option value="">-- Select Absent Teacher --</option>
                @foreach($absentTeachers as $teacher)
                    @foreach($teacher->absences as $absence)
                        <option value="{{ $absence->id }}"
                            data-teacher-id="{{ $teacher->id }}"
                            data-start="{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}"
                            data-end="{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}"
                            data-day="{{ \Carbon\Carbon::parse($absence->date)->format('l') }}">
                            {{ $teacher->name }} ({{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }})
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>

        {{-- Auto-filled Info --}}
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Start Date</label>
                <input type="text" id="start_date" class="form-control bg-light shadow-sm" readonly>
                <input type="hidden" name="start_date" id="start_date_hidden">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">End Date</label>
                <input type="text" id="end_date" class="form-control bg-light shadow-sm" readonly>
                <input type="hidden" name="end_date" id="end_date_hidden">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Day</label>
                <input type="text" id="day" class="form-control bg-light shadow-sm" readonly>
                <input type="hidden" name="day" id="day_hidden">
            </div>
        </div>

        {{-- Schedule Table --}}
        <h5 class="fw-bold mb-3 text-secondary">
            <i class="fas fa-clock me-2"></i> Assign Subjects and Substitute Teachers
        </h5>

        <div class="table-responsive shadow-sm rounded-3 mb-4">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Time Slot</th>
                        <th>Subject</th>
                        <th>Substitute Teacher</th>
                    </tr>
                </thead>
                <tbody id="schedule-body">
                    {{-- Rows inserted dynamically --}}
                </tbody>
            </table>
        </div>

        {{-- Form Buttons --}}
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary fw-semibold shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-gradient fw-semibold shadow-sm">
                <i class="fas fa-save me-1"></i> Save Schedule
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const absenceSelect = document.getElementById('absence_id');
    const teacherIdInput = document.getElementById('teacher_id');
    const dateInput = document.getElementById('date'); // ✅ Added
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const dayInput = document.getElementById('day');
    const startDateHidden = document.getElementById('start_date_hidden');
    const endDateHidden = document.getElementById('end_date_hidden');
    const dayHidden = document.getElementById('day_hidden');
    const tbody = document.getElementById('schedule-body');

    const timeSlots = [
        '6:00-7:00', '7:00-8:00', '8:15-9:15',
        '9:15-10:15', '10:15-11:15', '11:15-12:15'
    ];

    // Format date strings like "Nov 11, 2025" to "2025-11-11"
    const formatDateForInput = (dateStr) => {
        const months = { Jan:'01', Feb:'02', Mar:'03', Apr:'04', May:'05', Jun:'06', Jul:'07', Aug:'08', Sep:'09', Oct:'10', Nov:'11', Dec:'12' };
        const parts = dateStr.split(' ');
        if (parts.length !== 3) return '';
        const month = months[parts[0]];
        const day = parts[1].replace(',', '').padStart(2, '0');
        const year = parts[2];
        return `${year}-${month}-${day}`;
    };

    absenceSelect.addEventListener('change', async () => {
        const selected = absenceSelect.selectedOptions[0];
        if (!selected) return;

        // Set hidden teacher_id input for form submission
        teacherIdInput.value = selected.dataset.teacherId;

        // Display formatted start/end/day on readonly inputs
        startDateInput.value = selected.dataset.start;
        endDateInput.value = selected.dataset.end;
        dayInput.value = selected.dataset.day;

        // Also set hidden inputs in "Y-m-d" format for submission
        startDateHidden.value = formatDateForInput(selected.dataset.start);
        endDateHidden.value = formatDateForInput(selected.dataset.end);
        dayHidden.value = selected.dataset.day;

        // ✅ Set the date field from absence start date
        dateInput.value = formatDateForInput(selected.dataset.start);

        const teacherId = teacherIdInput.value;
        const day = dayInput.value;
        if (!teacherId || !day) return;

        tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Loading schedule...</td></tr>';

        try {
            // Fetch schedules for absent teacher on selected day
            const response = await fetch(`/api/teacher-schedules?teacher_id=${encodeURIComponent(teacherId)}&day=${encodeURIComponent(day)}`);
            const scheduleData = response.ok ? await response.json() : [];
            tbody.innerHTML = '';

            for (const slot of timeSlots) {
                const rowData = scheduleData.find(d => d.time_slot?.trim() === slot.trim()) || null;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-center fw-medium">
                        ${slot}
                        <input type="hidden" name="time_slots[]" value="${slot}">
                    </td>
                    <td>
                        <select name="subject_ids[]" class="form-select shadow-sm subject-select" required>
                            <option value="">-- Select Subject --</option>
                        </select>
                        <input type="hidden" name="subject_rooms[]" class="subject-room-input" value="">
                    </td>
                    <td>
                        <select name="substitute_ids[]" class="form-select shadow-sm substitute-select">
                            <option value="">-- Select Substitute --</option>
                        </select>
                        <input type="hidden" name="status[]" value="Available" class="status-input">
                        <input type="hidden" name="class_ids[]" value="">
                    </td>
                `;
                tbody.appendChild(tr);

                const subjectDropdown = tr.querySelector('.subject-select');
                const subjectRoomInput = tr.querySelector('.subject-room-input');
                const substituteDropdown = tr.querySelector('.substitute-select');
                const statusInput = tr.querySelector('.status-input');

                if (rowData && rowData.subject_room) {
                    const subjectText = rowData.subject_room.trim();
                    const subjectIdNum = Number(rowData.subject_id) || 0;
                    const subjectTextLower = subjectText.toLowerCase();

                    if (subjectIdNum === 0 || subjectTextLower === 'available' || subjectTextLower === 'vacant') {
                        subjectDropdown.innerHTML = '<option value="0" selected>VACANT</option>';
                        subjectDropdown.disabled = true;
                        substituteDropdown.disabled = true;
                        statusInput.value = "Vacant";
                        subjectRoomInput.value = "VACANT";
                    } else {
                        subjectDropdown.innerHTML = '';
                        const opt = document.createElement('option');
                        opt.value = subjectIdNum;
                        opt.textContent = subjectText;
                        opt.selected = true;
                        subjectDropdown.appendChild(opt);
                        subjectDropdown.disabled = false;
                        substituteDropdown.disabled = false;
                        statusInput.value = "Reserved";
                        subjectRoomInput.value = subjectText;
                    }
                } else {
                    subjectDropdown.innerHTML = '<option value="">-- Select Subject --</option>';
                    subjectRoomInput.value = "VACANT";
                    statusInput.value = "Available";
                    substituteDropdown.disabled = true;
                }

                try {
                    const res = await fetch(`/schedules/available-teachers?day=${encodeURIComponent(day)}&time_slot=${encodeURIComponent(slot)}`);
                    const teachers = res.ok ? await res.json() : [];
                    substituteDropdown.innerHTML = '<option value="">-- Select Substitute --</option>';
                    if (Array.isArray(teachers)) {
                        teachers.forEach(t => {
                            const opt = document.createElement('option');
                            opt.value = t.id;
                            opt.textContent = t.name;
                            substituteDropdown.appendChild(opt);
                        });
                    }
                } catch {
                    substituteDropdown.innerHTML = '<option disabled>Error loading substitutes</option>';
                }

                subjectDropdown.addEventListener('change', () => {
                    const selectedText = subjectDropdown.options[subjectDropdown.selectedIndex]?.text?.trim().toLowerCase() || '';
                    subjectRoomInput.value = subjectDropdown.options[subjectDropdown.selectedIndex]?.text || '';

                    if (selectedText === 'available' || selectedText === 'vacant' || subjectDropdown.value === '0') {
                        substituteDropdown.disabled = true;
                        substituteDropdown.value = '';
                        statusInput.value = 'Vacant';
                    } else {
                        substituteDropdown.disabled = false;
                        statusInput.value = substituteDropdown.value ? 'Reserved' : 'Available';
                    }
                });

                substituteDropdown.addEventListener('change', () => {
                    if (substituteDropdown.value) {
                        statusInput.value = 'Reserved';
                    } else {
                        if (subjectDropdown.value === '0') {
                            statusInput.value = 'Vacant';
                        } else {
                            statusInput.value = 'Available';
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error fetching schedule:', error);
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">Error loading schedule.</td></tr>';
        }
    });
});
</script>

<style>
.card { border-radius: 1rem; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
.table-hover tbody tr:hover { background-color: #f1f5f9; }
.btn-gradient { background: linear-gradient(135deg, #0d6efd, #6610f2); border: none; color: #fff; }
.btn-gradient:hover { background: linear-gradient(135deg, #6610f2, #0d6efd); }
.form-control, .form-select { border-radius: 0.5rem; transition: all 0.2s; }
.form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25); }
</style>
@endsection
