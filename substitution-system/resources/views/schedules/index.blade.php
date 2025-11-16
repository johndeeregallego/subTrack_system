@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Page Title --}}
    <h1 class="text-center fw-bold mb-4 text-primary">
        <i class="fas fa-calendar-alt me-2"></i> Teacher Weekly Schedule
    </h1>

    {{-- Top Controls --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('schedules.create') }}" class="btn btn-primary fw-semibold shadow-sm">
            <i class="fas fa-plus me-1"></i> Add Schedule
        </a>
        <input type="text" id="scheduleSearch" class="form-control w-25 shadow-sm" placeholder="Search teacher...">
    </div>

    @php
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
        $timeSlots = ['6:00-7:00','7:00-8:00','8:15-9:15','9:15-10:15','10:15-11:15','11:15-12:15'];
    @endphp

    {{-- Bulk Delete Form --}}
    <form id="bulkDeleteForm" action="{{ route('schedules.bulkDelete') }}" method="POST">

        @csrf
        @method('DELETE')

        {{-- Day Tabs --}}
        <ul class="nav nav-tabs mb-3 justify-content-center shadow-sm rounded" id="dayTabs" role="tablist">
            @foreach($days as $index => $day)
                <li class="nav-item" role="presentation">
                    <button 
                        type="button"
                        class="nav-link {{ $index === 0 ? 'active text-white bg-primary' : 'text-primary bg-light' }} fw-semibold"
                        id="tab-{{ strtolower($day) }}"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ strtolower($day) }}"
                        role="tab"
                        aria-controls="{{ strtolower($day) }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        {{ $day }}
                    </button>
                </li>
            @endforeach
        </ul>



        {{-- Tab Contents --}}
        <div class="tab-content">
            @foreach($days as $index => $day)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ strtolower($day) }}">
                    
                    <div class="d-flex justify-content-end mb-2 align-items-center gap-3">
                        <button type="submit" class="btn btn-danger btn-sm fw-semibold">
                            <i class="fas fa-trash me-1"></i> Delete Selected
                        </button>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input select-all" data-day="{{ strtolower($day) }}" id="selectAll-{{ strtolower($day) }}">
                            <label class="form-check-label" for="selectAll-{{ strtolower($day) }}">Select All</label>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4 rounded-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" disabled></th>
                                        <th class="fw-bold">Teacher</th>
                                        @foreach($timeSlots as $slot)
                                            <th>{{ $slot }}</th>
                                        @endforeach
                                        <th class="fw-bold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules->groupBy('teacher_id') as $teacherId => $teacherSchedules)
                                        @php
                                            $firstSchedule = $teacherSchedules->first();
                                            $teacher = $firstSchedule?->teacher;
                                            $daySchedules = $teacherSchedules->where('day', $day)->keyBy('time_slot');
                                        @endphp
                                        <tr>
                                            {{-- Checkbox for bulk delete --}}
                                            <td>
                                                @if($firstSchedule)
                                                    <input type="checkbox" name="selected_schedules[]" value="{{ $firstSchedule->id }}" class="form-check-input checkbox-{{ strtolower($day) }}">
                                                @endif
                                            </td>

                                            {{-- Teacher Name --}}
                                            <td class="text-start fw-semibold">{{ $teacher?->name ?? 'N/A' }}</td>

                                            {{-- Schedule Time Slots --}}
                                            @foreach($timeSlots as $slot)
                                                @php $schedule = $daySchedules[$slot] ?? null; @endphp
                                                <td>
                                                    @if($schedule)
                                                        <span class="badge {{ $schedule->is_vacant || $schedule->subject_id == 0 ? 'bg-success' : 'bg-primary' }}">
                                                            {{ $schedule->is_vacant || $schedule->subject_id == 0 ? 'Available' : ($schedule->subject_room ?? 'Reserved') }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">N/A</span>
                                                    @endif
                                                </td>
                                            @endforeach

                                            {{-- Actions --}}
                                            <td class="d-flex gap-2 justify-content-center">
                                                @if($teacher)
                                                    <a href="{{ route('schedules.editWeekly', ['teacher' => $teacher->id]) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                @endif
                                                @if($firstSchedule)
                                                    <form action="{{ route('schedules.destroy', $firstSchedule->id) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this schedule?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash me-1"></i>Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </form>
</div>

{{-- ======= SCRIPT ======= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ====== Search Filter ======
    const searchInput = document.getElementById('scheduleSearch');
    let debounceTimer;
    searchInput?.addEventListener('keyup', function () {
        clearTimeout(debounceTimer);
        const filter = this.value.toLowerCase();
        debounceTimer = setTimeout(() => {
            document.querySelectorAll('.tab-pane tbody tr').forEach(row => {
                const nameCell = row.querySelector('td:nth-child(2)');
                const name = nameCell?.innerText.toLowerCase() || '';
                row.style.display = name.includes(filter) ? '' : 'none';
            });
        }, 150);
    });

    // ====== Select All per Tab ======
    document.querySelectorAll('.select-all').forEach(checkbox => {
        const day = checkbox.dataset.day;
        checkbox.addEventListener('change', function () {
            const checkboxes = document.querySelectorAll(`.checkbox-${day}`);
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });

    // ====== Update "Select All" if individual checkboxes are toggled ======
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        const day = cb.closest('tbody')?.closest('.tab-pane')?.id;
        if (!day) return;
        cb.addEventListener('change', () => {
            const all = document.querySelectorAll(`.checkbox-${day}`);
            const selectAll = document.querySelector(`.select-all[data-day="${day}"]`);
            if (!selectAll) return;
            selectAll.checked = Array.from(all).every(c => c.checked);
        });
    });

    // ====== Confirm only on actual delete click ======
    document.querySelector('#bulkDeleteForm')?.addEventListener('submit', (e) => {
        const checked = document.querySelectorAll('input[name="selected_schedules[]"]:checked');
        if (checked.length === 0) {
            e.preventDefault();
            alert('Please select at least one schedule to delete.');
            return;
        }
        if (!confirm('Delete selected schedules?')) {
            e.preventDefault();
        }
    });

    // ====== Dynamic Tab Color Switching ======
    const tabs = document.querySelectorAll('#dayTabs .nav-link');

    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            // Reset all tab colors
            tabs.forEach(btn => btn.classList.remove('bg-primary', 'text-white', 'bg-light', 'text-primary'));
            // Apply active color to current tab
            this.classList.add('bg-primary', 'text-white');
        });

        tab.addEventListener('hide.bs.tab', function () {
            this.classList.remove('bg-primary', 'text-white');
            this.classList.add('bg-light', 'text-primary');
        });
    });

});
</script>

@endsection
