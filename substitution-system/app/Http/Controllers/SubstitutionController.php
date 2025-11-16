<?php

namespace App\Http\Controllers;

use App\Models\Substitution;
use App\Models\Teacher;
use App\Models\Absence;
use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubstitutionController extends Controller
{
    // ============================
    // INDEX
    // ============================
    public function index()
{
    $substitutions = Substitution::with(['teacher', 'substitute', 'absence', 'subject'])  // <-- added 'subject'
        ->orderBy('date', 'desc')
        ->get();

    return view('substitutions.index', compact('substitutions'));
}


    // ============================
    // CREATE
    // ============================
    public function create()
    {
        $teachers = Teacher::all();

        $absentTeachers = Teacher::with(['absences' => function ($q) {
            $q->orderBy('date', 'asc');
        }])->has('absences')->get();

        $subjects = Subject::all();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $timeSlots = [
            '6:00-7:00',
            '7:00-8:00',
            '8:15-9:15',
            '9:15-10:15',
            '10:15-11:15',
            '11:15-12:15',
        ];

        return view('substitutions.create', compact(
            'teachers',
            'absentTeachers',
            'subjects',
            'days',
            'timeSlots'
        ));
    }

    // ============================
    // STORE
    // ============================
  public function store(Request $request)
{
    // ✅ 1. Validation including date
    $request->validate([
        'absence_id' => 'required|exists:absences,id',
        'teacher_id' => 'required|exists:teachers,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'day' => 'required|string',
        'date' => 'required|date', // ✅ Added
        'time_slots' => 'required|array',
        'subject_ids' => 'required|array',
        'substitute_ids' => 'required|array',
        'status' => 'required|array',
    ]);

    $absenceId = $request->absence_id;
    $teacherId = $request->teacher_id;
    $startDate = $request->start_date;
    $endDate = $request->end_date;
    $day = $request->day;
    $date = $request->date; // ✅ Added

    $timeSlots = $request->time_slots;
    $subjectIds = $request->subject_ids;
    $substituteIds = $request->substitute_ids;
    $statuses = $request->status;

    foreach ($timeSlots as $index => $timeSlot) {
        if (empty($substituteIds[$index]) || $subjectIds[$index] == 0) {
            continue;
        }

        Substitution::create([
            'absence_id' => $absenceId,
            'teacher_id' => $teacherId,
            'time_slot' => $timeSlot,
            'subject_id' => $subjectIds[$index],
            'substitute_id' => $substituteIds[$index],
           // 'start_date' => $startDate,
           // 'end_date' => $endDate,
            'day' => $day,
            'date' => $date, // ✅ Added
            //'status' => $statuses[$index] ?? 'Available',
        ]);
    }

    return redirect()->route('substitutions.index')->with('success', 'Substitution schedule created successfully.');
}

public function edit($id)
{
    $substitution = Substitution::findOrFail($id);

    $absentTeachers = Teacher::with('absences')->get();
    $teachers = Teacher::all();
    $subjects = Subject::all();
    $substitutes = Teacher::all();

    // Define time slots as in your create form
    $timeSlots = [
        '6:00-7:00', '7:00-8:00', '8:15-9:15',
        '9:15-10:15', '10:15-11:15', '11:15-12:15'
    ];

    return view('substitutions.edit', compact(
        'substitution',
        'absentTeachers',
        'teachers',
        'subjects',
        'substitutes',
        'timeSlots'
    ));
}
public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'absence_id' => 'required|exists:absences,id',
        'time_slots' => 'required|array',
        'substitute_ids' => 'required|array',
        'substitute_ids.*' => 'nullable|exists:teachers,id',
    ]);

    // Find the substitution record to update
    $substitution = Substitution::findOrFail($id);

    // Update fields
    $substitution->absence_id = $request->absence_id;
    // Since your form only edits one time slot and one substitute:
    $substitution->time_slot = $request->time_slots[0];
    $substitution->substitute_id = $request->substitute_ids[0];
    
    // Save changes
    $substitution->save();

    // Redirect back with success message
    return redirect()->route('substitutions.index')->with('success', 'Substitution updated successfully.');
}
public function bulkDelete(Request $request)
{
    $ids = $request->input('ids');

    if (!$ids || !is_array($ids)) {
        return redirect()->route('substitutions.index')->with('error', 'No substitutions selected for deletion.');
    }

    Substitution::whereIn('id', $ids)->delete();

    return redirect()->route('substitutions.index')->with('success', 'Selected substitutions have been deleted.');
}
public function destroy($id)
{
    $substitution = Substitution::findOrFail($id);
    $substitution->delete();

    return redirect()->route('substitutions.index')->with('success', 'Substitution deleted successfully.');
}



    // ... rest of your controller as before ...
}
