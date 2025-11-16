@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="text-center mb-5">
        <img src="{{ asset('img/cnhs_logo.png') }}" alt="CNHS Logo" class="mb-2" style="width: 80px; height: 80px;">
        <h1 class="h4 fw-bold mb-1 text-dark">CNHS Substitution Management Dashboard</h1>
        <p class="text-muted mb-0">Manage teachers, subjects, absences, and substitutions efficiently</p>
    </div>

    <!-- Summary Cards -->
    @php
    $cards = [
        ['title'=>'Teachers','count'=>$teachersCount,'route'=>'teachers.index','icon'=>'fa-chalkboard-teacher','tooltip'=>'Manage Teachers','class'=>'teachers'],
        ['title'=>'Subjects','count'=>$subjectsCount,'route'=>'subjects.index','icon'=>'fa-book','tooltip'=>'Manage Subjects','class'=>'subjects'],
        ['title'=>'Absences','count'=>$absencesCount,'route'=>'absences.index','icon'=>'fa-user-slash','tooltip'=>'View Absences','class'=>'absences'],
        ['title'=>'Substitutions','count'=>$substitutionsCount,'route'=>'substitutions.index','icon'=>'fa-exchange-alt','tooltip'=>'View Substitutions','class'=>'substitutions'],
        ['title'=>'Schedules','count'=>$schedulesCount,'route'=>'schedules.index','icon'=>'fa-clock','tooltip'=>'View Schedules','class'=>'schedules'],
        ['title'=>'Teacher Subs','count'=>$teacherSubsLeaderboard->sum('substitutions_as_substitute_count'),'route'=>'teachers.index','icon'=>'fa-star','tooltip'=>'Teacher Substitution Leaderboard','class'=>'teacher-subs'],
    ];
    @endphp

    <div class="row g-3 mb-5">
        @foreach($cards as $card)
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card shadow-sm border-0 text-center h-100 animated-card {{ $card['class'] }}" data-bs-toggle="tooltip" title="{{ $card['tooltip'] }}">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fas {{ $card['icon'] }} fa-2x mb-2 text-white animated-icon"></i>
                    <h6 class="card-title text-uppercase small text-white">{{ $card['title'] }}</h6>
                    <h2 class="card-count my-2 text-white">{{ $card['count'] }}</h2>
                    <a href="{{ route($card['route']) }}" class="btn btn-sm btn-light fw-bold">Manage</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-12 col-lg-6">
            @foreach([
                ['title'=>'Latest Teachers','color'=>'primary','items'=>$latestTeachers,'icon'=>'fa-user','field'=>'name','extra'=>'department'],
                ['title'=>'Latest Subjects','color'=>'warning','items'=>$latestSubjects,'icon'=>'fa-book','field'=>'title','extra'=>''],
                ['title'=>'Latest Absences','color'=>'danger','items'=>$latestAbsences,'icon'=>'fa-user-slash','isAbsence'=>true],
                ['title'=>'Latest Substitutions','color'=>'info','items'=>$latestSubstitutions,'icon'=>'fa-exchange-alt','isSub'=>true]
            ] as $panel)
            <div class="card shadow-sm mb-4 border-0 card-hover">
                <div class="card-header bg-{{ $panel['color'] }} text-white fw-bold">{{ $panel['title'] }}</div>
                <ul class="list-group list-group-flush">
                    @forelse($panel['items'] as $item)
                        @if(isset($panel['isAbsence']) && $panel['isAbsence'])
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas {{ $panel['icon'] }} text-{{ $panel['color'] }} me-2"></i>
                            {{ $item->teacher->name ?? 'N/A' }} - {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}
                        </li>
                        @elseif(isset($panel['isSub']) && $panel['isSub'])
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas {{ $panel['icon'] }} text-{{ $panel['color'] }} me-2"></i>
                            {{ $item->teacher->name ?? 'N/A' }} → {{ $item->substitute->name ?? 'N/A' }} ({{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }})
                        </li>
                        @else
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas {{ $panel['icon'] }} text-{{ $panel['color'] }} me-2"></i>
                                {{ $item->{$panel['field']} ?? $item->name }}
                                @if($panel['extra'])
                                    <span class="badge bg-light text-dark ms-1">{{ $item->{$panel['extra']} }}</span>
                                @endif
                            </div>
                        </li>
                        @endif
                    @empty
                        <li class="list-group-item text-muted">No records found.</li>
                    @endforelse
                </ul>
            </div>
            @endforeach
        </div>

        <!-- Right Column -->
        <div class="col-12 col-lg-6">
            <!-- Substitution Leaderboard -->
            <div class="card shadow-sm mb-4 border-0 card-hover">
                <div class="card-header bg-dark text-white fw-bold d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <span>Substitution Leaderboard</span>
                    <input type="text" id="leaderboardSearch" class="form-control form-control-sm mt-2 mt-md-0 w-100 w-md-50" placeholder="Search teacher...">
                </div>
                <ul class="list-group list-group-flush" id="leaderboardList">
                    @forelse($teacherSubsLeaderboard as $teacher)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user text-dark me-2"></i> <strong>{{ $teacher->name }}</strong></span>
                        <span class="badge bg-dark rounded-pill">{{ $teacher->substitutions_as_substitute_count }}</span>
                    </li>
                    @empty
                        <li class="list-group-item text-muted">No substitution records yet.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Available Teachers by Day -->
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
            @php
                $teachers = $availableTeachersByDay[$day] ?? collect();
                $visibleCount = 3;
            @endphp
            <div class="card shadow-sm mb-4 border-0 card-hover">
                <div class="card-header bg-success text-white fw-bold d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <span>{{ $day }} — Available Teachers</span>
                    <input type="text" class="form-control form-control-sm mt-2 mt-md-0 w-100 w-md-50 day-search" placeholder="Search teacher...">
                </div>
                <ul class="list-group list-group-flush day-list">
                    @forelse($teachers->unique('id')->take($visibleCount) as $teacher)
                    @php
                        $slots = $teacher->schedules->where('day', $day)->where('is_vacant', true)->pluck('time_slot')->toArray();
                    @endphp
                    <li class="list-group-item d-flex flex-column">
                        <div><i class="fas fa-user text-success me-2"></i> <strong>{{ $teacher->name }}</strong></div>
                        @if(count($slots))
                        <div class="mt-1">
                            @foreach($slots as $slot)
                                <span class="badge bg-secondary me-1">{{ $slot }}</span>
                            @endforeach
                        </div>
                        @endif
                    </li>
                    @empty
                    <li class="list-group-item text-muted">No available teachers on {{ $day }}.</li>
                    @endforelse

                    @php
                        $remaining = $teachers->unique('id')->slice($visibleCount);
                    @endphp
                    @if($remaining->count())
                    <div class="collapse multi-collapse" id="more-{{ Str::slug($day) }}">
                        @foreach($remaining as $teacher)
                        @php
                            $slots = $teacher->schedules->where('day', $day)->where('is_vacant', true)->pluck('time_slot')->toArray();
                        @endphp
                        <li class="list-group-item d-flex flex-column">
                            <div><i class="fas fa-user text-success me-2"></i> <strong>{{ $teacher->name }}</strong></div>
                            @if(count($slots))
                            <div class="mt-1">
                                @foreach($slots as $slot)
                                    <span class="badge bg-secondary me-1">{{ $slot }}</span>
                                @endforeach
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </div>
                    <li class="list-group-item text-center">
                        <button class="btn btn-sm btn-outline-success toggle-show-more" type="button" data-bs-toggle="collapse" data-bs-target="#more-{{ Str::slug($day) }}" aria-expanded="false">
                            Show More
                        </button>
                    </li>
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Styles -->
<style>
body { background: #f5f7fa; }

/* Summary Cards */
.animated-card {
    border-radius: 0.75rem;
    overflow: hidden;
    background-size: 400% 400%;
    transition: transform 0.3s, box-shadow 0.3s, background-position 0.5s;
}
.animated-card.teachers { background: linear-gradient(135deg, #6a11cb, #2575fc); }
.animated-card.subjects { background: linear-gradient(135deg, #f7971e, #ffd200); }
.animated-card.absences { background: linear-gradient(135deg, #dc3545, #a71d2a); }
.animated-card.substitutions { background: linear-gradient(135deg, #17a2b8, #138496); }
.animated-card.schedules { background: linear-gradient(135deg, #6c757d, #495057); }
.animated-card.teacher-subs { background: linear-gradient(135deg, #343a40, #212529); }

/* Gradient Hover Animation */
.animated-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animated-icon { display: inline-block; animation: pulseIcon 2.5s infinite ease-in-out; }
@keyframes pulseIcon { 0%,100% { transform: scale(1); } 50% { transform: scale(1.15); } }

.card-count { font-size: 2rem; font-weight: bold; color: #fff; }
.list-group-item { font-size: 0.95rem; transition: background 0.2s; }
.list-group-item:hover { background: #f1f3f5; }
.list-group-item i { margin-right: 8px; }
.highlight { background-color: #fffb91; }
.badge { font-weight: 500; }

@media (max-width: 767px) {
    .card-body { padding: 1rem !important; }
    .card-title { font-size: 0.85rem; }
    .card-count { font-size: 1.5rem; }
}
</style>
@endsection
