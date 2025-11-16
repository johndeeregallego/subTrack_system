<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Teacher;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    /**
     * Display all absences grouped by teacher and reason.
     */
    public function index()
    {
        $absences = Absence::with('teacher')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->teacher_id . '|' . $item->reason;
            });

        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for recording a new absence.
     */
    public function create()
    {
        // Only teachers who are available (not absent) should appear
        $teachers = Teacher::where('is_available', 1)
            ->where('is_absent', 0)
            ->orderBy('name')
            ->get();

        return view('absences.create', compact('teachers'));
    }

    /**
     * Store a newly created absence and update teacher status.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'nullable|string|max:255',
        ]);

        $teacher = Teacher::findOrFail($request->teacher_id);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $daysCount = 0;

        while ($start->lte($end)) {
            if ($start->isWeekday()) {
                Absence::create([
                    'teacher_id' => $teacher->id,
                    'date'       => $start->toDateString(),
                    'reason'     => $request->reason,
                ]);
                $daysCount++;
            }
            $start->addDay();
        }

        // ✅ Update teacher availability status
        $teacher->update([
            'is_absent'    => 1,
            'is_available' => 0,
        ]);

        return redirect()
            ->route('absences.index')
            ->with('success', "Absence recorded for {$daysCount} day(s). Teacher status updated.");
    }

    /**
     * Edit an existing absence record.
     */
    public function edit(Absence $absence)
    {
        $teachers = Teacher::orderBy('name')->get();
        return view('absences.edit', compact('absence', 'teachers'));
    }

    /**
     * Update an existing absence.
     */
    public function update(Request $request, Absence $absence)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date'       => 'required|date',
            'reason'     => 'nullable|string|max:255',
        ]);

        $absence->update([
            'teacher_id' => $request->teacher_id,
            'date'       => $request->date,
            'reason'     => $request->reason,
        ]);

        return redirect()
            ->route('absences.index')
            ->with('success', 'Absence updated successfully.');
    }

    /**
     * Remove an absence record and restore teacher status if applicable.
     */
    public function destroy(Absence $absence)
    {
        $teacher = $absence->teacher;

        $absence->delete();

        // ✅ Restore teacher status only if no other absences remain
        $hasRemaining = Absence::where('teacher_id', $teacher->id)->exists();

        if (!$hasRemaining) {
            $teacher->update([
                'is_absent'    => 0,
                'is_available' => 1,
            ]);
        }

        return redirect()
            ->route('absences.index')
            ->with('success', 'Absence deleted successfully. Teacher status reset.');
    }

    /**
     * 🔹 For autofill department based on selected teacher.
     */
    public function getTeacherDepartment($id)
    {
        $teacher = Teacher::find($id);

        return response()->json([
            'department' => $teacher->department ?? '',
        ]);
    }

    /**
     * 🔹 For autofill of existing absence date (optional use).
     */
    public function getDate($teacherId)
    {
        $absence = Absence::where('teacher_id', $teacherId)->first();

        return response()->json([
            'date' => $absence ? $absence->date : null,
        ]);
    }
}
