@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-blue fw-bold">
            Add Teacher Schedule
        </div>
        <div class="card-body">
            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('schedules.store') }}" method="POST">
                @csrf

                {{-- Select Teacher --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Teacher</label>
                    <select name="teacher_id" class="form-select" required>
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Accordion --}}
                @php
                    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
                    $timeSlots = ['6:00-7:00','7:00-8:00','8:15-9:15','9:15-10:15','10:15-11:15','11:15-12:15'];
                @endphp
                <div class="accordion mb-3" id="scheduleAccordion">
                    @foreach($days as $day)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $day }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $day }}">
                                    {{ $day }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $day }}" class="accordion-collapse collapse" data-bs-parent="#scheduleAccordion">
                                <div class="accordion-body p-3">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr><th>Time Slot</th><th>Status</th><th>Subject</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($timeSlots as $slot)
                                            <tr>
                                                <td>{{ $slot }}</td>
                                                <td>
                                                    @php
                                                        $oldStatus = old("status.$day.$slot", 'Available');
                                                    @endphp
                                                    <select name="status[{{ $day }}][{{ $slot }}]" class="form-select">
                                                        <option value="Available">Available</option>
                                                        <option value="Reserved">Reserved</option>
                                                    </select>

                                                </td>
                                                <td>
                                                    @php
                                                        $oldSubject = old("subject.$day.$slot");
                                                        $disabled = $oldStatus === 'Available' ? 'disabled' : '';
                                                    @endphp
                                                   <select name="subject[{{ $day }}][{{ $slot }}]" class="form-select">
                                                        <option value="">-- Select Subject --</option>
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">
                                                                {{ $subject->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

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

                <button type="submit" class="btn btn-primary rounded-3">Save Schedule</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-select').forEach(select => {
        const subject = select.closest('tr').querySelector('.subject-select');
        const toggle = () => {
            subject.disabled = select.value === 'Available';
        };
        toggle();
        select.addEventListener('change', toggle);
    });
});
</script>
@endsection
