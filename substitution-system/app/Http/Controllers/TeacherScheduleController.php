<?php

// app/Http/Controllers/TeacherScheduleController.php
namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherSchedule;
use Illuminate\Http\Request;

class TeacherScheduleController extends Controller
{
    public function index()
    {
        $schedules = TeacherSchedule::with('teacher')->get();
        return view('teacher_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $timeSlots = [
            "6:00-7:00",
            "7:00-8:00",
            "8:15-9:15",
            "10:15-11:15",
            "11:15-12:15"
        ];
        return view('teacher_schedules.create', compact('teachers', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'time_slot' => 'required|string',
            'is_vacant' => 'required|boolean',
        ]);

        TeacherSchedule::create($request->all());

        return redirect()->route('teacher_schedules.index')->with('success', 'Schedule added successfully.');
    }

    public function edit(TeacherSchedule $teacherSchedule)
    {
        $teachers = Teacher::all();
        $timeSlots = [
            "6:00-7:00",
            "7:00-8:00",
            "8:15-9:15",
            "10:15-11:15",
            "11:15-12:15"
        ];
        return view('teacher_schedules.edit', compact('teacherSchedule', 'teachers', 'timeSlots'));
    }

    public function update(Request $request, TeacherSchedule $teacherSchedule)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'time_slot' => 'required|string',
            'is_vacant' => 'required|boolean',
        ]);

        $teacherSchedule->update($request->all());

        return redirect()->route('teacher_schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(TeacherSchedule $teacherSchedule)
    {
        $teacherSchedule->delete();
        return redirect()->route('teacher_schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
