<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Absence;
use App\Models\Substitution;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary counts
        $teachersCount      = Teacher::count();
        $classesCount       = ClassModel::count();
        $subjectsCount      = Subject::count(); // Added
        $absencesCount      = Absence::count();
        $substitutionsCount = Substitution::count();
        $schedulesCount     = Schedule::count();

        // Latest records
        $latestTeachers      = Teacher::latest()->take(5)->get();
        $latestClasses       = ClassModel::latest()->take(5)->get();
        $latestSubjects      = Subject::latest()->take(5)->get(); // Added
        $latestAbsences      = Absence::with('teacher')->latest()->take(5)->get();
        $latestSubstitutions = Substitution::with(['teacher','substitute'])->latest()->take(5)->get();
        $latestSchedules     = Schedule::with('teacher')->latest()->get();

        // Teacher substitution leaderboard
        $teacherSubsLeaderboard = Teacher::withCount('substitutionsAsSubstitute')
            ->orderByDesc('substitutions_as_substitute_count')
            ->take(5)
            ->get();

        // Available teachers per day
        $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
        $availableTeachersByDay = [];
        foreach($daysOfWeek as $day){
            $availableTeachersByDay[$day] = Teacher::whereHas('schedules', function($q) use($day){
                $q->where('day', $day)->where('is_vacant', true);
            })->get();
        }

        return view('dashboard', compact(
            'teachersCount',
            'classesCount',
            'subjectsCount',       // Added
            'absencesCount',
            'substitutionsCount',
            'schedulesCount',
            'latestTeachers',
            'latestClasses',
            'latestSubjects',      // Added
            'latestAbsences',
            'latestSubstitutions',
            'latestSchedules',
            'teacherSubsLeaderboard',
            'availableTeachersByDay'
        ));
    }
}
