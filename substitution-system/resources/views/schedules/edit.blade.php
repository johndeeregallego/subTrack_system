@extends('layouts.app')
@section('content')
<div class="container py-4">

    <div class="card shadow border-0 rounded-4">
        {{-- Header --}}
        <div class="card-header bg-gradient-primary text-white fw-bold fs-5">
            Edit Schedule for {{ $schedule->teacher->name }}
        </div>

        <div class="card-body">

            <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" id="scheduleForm">
                @csrf
                @method('PUT')

                {{-- Select Teacher --}}
                <div class="mb-4">
                    <label for="teacher_id" class="form-label fw-semibold">Select Teacher</label>
                    <select name="teacher_id" id="teacher_id" class="form-select" required>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $schedule->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @php
                    $days = $days ?? ['Monday','Tuesday','Wednesday','Thursday','Friday'];
                    $timeSlots = $timeSlots ?? ['6:00-7:00','7:00-8:00','8:15-9:15','9:15-10:15','10:15-11:15','11:15-12:15'];
                @endphp

                {{-- Accordion per day --}}
                <div class="accordion mb-3" id="scheduleAccordion">
                    @foreach($days as $day)
                        <div class="accordion-item rounded-3">
                            <h2 class="accordion-header" id="heading-{{ $day }}">
                                <button class="accordion-button @if(now()->format('l') != $day) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $day }}">
                                    {{ $day }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $day }}" class="accordion-collapse collapse @if(now()->format('l') == $day) show @endif" data-bs-parent="#scheduleAccordion">
                                <div class="accordion-body p-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center align-middle mb-0 schedule-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Time Slot</th>
                                                    <th>Status</th>
                                                    <th>Subject & Room</th>
                                                    <th>Substitute Teacher</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($timeSlots as $slot)
@php
    // Get the schedule for this day and time slot
    $sch = $schedules->firstWhere('day', $day)?->firstWhere('time_slot', $slot);
    $oldStatus = old("status.$day.$slot", $sch->is_vacant ? 'Available' : 'Reserved');
    $oldSubject = old("subject.$day.$slot", $sch->subject_id ?? '');
    $disabled = $oldStatus === 'Available' ? 'disabled' : '';
@endphp
<tr>
    <td>{{ $slot }}</td>
    <td>
        <select name="status[{{ $day }}][{{ $slot }}]" class="form-select status-select">
            <option value="Available" {{ $oldStatus === 'Available' ? 'selected' : '' }}>Available</option>
            <option value="Reserved" {{ $oldStatus === 'Reserved' ? 'selected' : '' }}>Reserved</option>
        </select>
    </td>
    <td>
        <select name="subject[{{ $day }}][{{ $slot }}]" class="form-select subject-select" {{ $disabled }}>
            <option value="">-- Select Subject --</option>
            @if($sch && $sch->subject)
                <option value="{{ $sch->subject->id }}" selected>
                    {{ $sch->subject->name }} / {{ $sch->subject->code }}
                </option>
            @endif
        </select>
    </td>
</tr>
@endforeach

                                                <tr data-day="{{ $day }}" data-slot="{{ $slot }}">
                                                    <td class="fw-semibold">{{ $slot }}</td>
                                                    <td>
                                                        <select name="status[{{ $day }}][{{ $slot }}]" class="form-select form-select-sm status-select" data-subject-id="subject-{{ $day }}-{{ $slot }}" data-teacher-id="substitute-{{ $day }}-{{ $slot }}">
                                                            <option value="1" {{ $sched?->is_vacant ? 'selected' : '' }}>Available</option>
                                                            <option value="0" {{ !$sched?->is_vacant ? 'selected' : '' }}>Reserved</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="subject[{{ $day }}][{{ $slot }}]" id="subject-{{ $day }}-{{ $slot }}" class="form-select form-select-sm subject-select" required>
                                                            <option value="">-- Select Subject --</option>
                                                            @foreach($subjects as $subject)
                                                                <option value="{{ $subject->id }}" {{ $sched && $sched->subject_id == $subject->id ? 'selected' : '' }}>
                                                                    {{ $subject->name }} / {{ $subject->code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="substitute[{{ $day }}][{{ $slot }}]" id="substitute-{{ $day }}-{{ $slot }}" class="form-select form-select-sm substitute-select">
                                                            <option value="">-- Select Substitute --</option>
                                                            @if(!$sched?->is_vacant && $substitute)
                                                                @php
                                                                    $teacher = $teachers->where('id', $substitute)->first();
                                                                @endphp
                                                                <option value="{{ $teacher->id }}" selected>{{ $teacher->name }}</option>
                                                            @endif
                                                        </select>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-3">Update Schedule</button>
                    <a href="{{ route('schedules.index') }}" class="btn btn-secondary px-4 rounded-3">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ======= STYLES ======= --}}
<style>
body { background-color: #f5f6fa; font-family: 'Inter', sans-serif; }
.accordion-button:not(.collapsed) { background-color: #e7f1ff; font-weight: 600; }
.table thead th { background-color: #0d6efd; color: #fff; font-weight: 600; }
.table-striped tbody tr:nth-of-type(even) { background-color: #f8f9fa; }
.schedule-table td, .schedule-table th { padding: 12px 8px; }
.status-select:disabled, .subject-select:disabled, .substitute-select:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

{{-- ======= SCRIPT ======= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-select').forEach(select => {
        const subject = document.getElementById(select.dataset.subjectId);
        const substitute = document.getElementById(select.dataset.teacherId);
        const row = select.closest('tr');
        const day = row.dataset.day;
        const slot = row.dataset.slot;

        const update = () => {
            if(select.value == '1'){ // Available
                subject.disabled = true;
                substitute.disabled = true;
                subject.classList.add('disabled-select');
                substitute.classList.add('disabled-select');
                substitute.innerHTML = '<option value="">-- Select Substitute --</option>';
            } else { // Reserved
                subject.disabled = false;
                substitute.disabled = false;
                subject.classList.remove('disabled-select');
                substitute.classList.remove('disabled-select');

                fetch(`/schedules/available-teachers?day=${day}&time_slot=${slot}`)
                    .then(res => res.json())
                    .then(data => {
                        substitute.innerHTML = '<option value="">-- Select Substitute --</option>';
                        data.forEach(t => {
                            const opt = document.createElement('option');
                            opt.value = t.id;
                            opt.textContent = t.name;
                            substitute.appendChild(opt);
                        });
                    });
            }
        };

        update();
        select.addEventListener('change', update);
    });
});
</script>
@endsection
