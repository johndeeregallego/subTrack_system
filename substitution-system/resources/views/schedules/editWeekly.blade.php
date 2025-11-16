@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-blue fw-bold fs-5">
            Edit Weekly Schedule - {{ $teacher->name }}
        </div>
        <div class="card-body">

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

           <form action="{{ route('schedules.updateWeekly', $teacher->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- This makes Laravel treat it as a PUT request --}}

    <div class="accordion mb-4" id="scheduleAccordion">
        @foreach($days as $day)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-{{ $day }}">
                    <button class="accordion-button collapsed bg-light text-dark fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $day }}">
                        {{ $day }}
                    </button>
                </h2>
                <div id="collapse-{{ $day }}" class="accordion-collapse collapse" data-bs-parent="#scheduleAccordion">
                    <div class="accordion-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Time Slot</th>
                                        <th>Status</th>
                                        <th>Subject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($timeSlots as $slot)
                                        @php
                                            $sch = $schedules->first(fn($s) => $s->day === $day && $s->time_slot === $slot);
                                            $oldStatus = old("status.$day.$slot", $sch->is_vacant ? 'Available' : 'Reserved');
                                            $oldSubject = old("subject.$day.$slot", $sch->subject_id ?? '');
                                        @endphp
                                        <tr>
                                            <td class="fw-medium">{{ $slot }}</td>
                                            <td>
                                                <select name="status[{{ $day }}][{{ $slot }}]" class="form-select status-select">
                                                    <option value="Available" {{ $oldStatus === 'Available' ? 'selected' : '' }}>Available</option>
                                                    <option value="Reserved" {{ $oldStatus === 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="subject[{{ $day }}][{{ $slot }}]" class="form-select subject-select">
                                                    <option value="">-- Select Subject --</option>
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}" {{ $oldSubject == $subject->id ? 'selected' : '' }}>
                                                            {{ $subject->name }} / {{ $subject->code }}
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
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 fw-semibold">Save Changes</button>
    </div>
</form>

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
