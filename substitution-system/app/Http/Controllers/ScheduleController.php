<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\Absence;


class ScheduleController extends Controller
{
    // List schedules
    public function index()
    {
        $schedules = Schedule::with(['teacher', 'subject'])->orderBy('day')->orderBy('time_slot')->get();
        return view('schedules.index', compact('schedules'));
    }

    // Create schedule
    public function create()
    {
        $teachers = Teacher::all();
    $subjects = Subject::all();
    $absences = Absence::with('teacher')->orderBy('date', 'desc')->get();

    return view('schedules.create', compact('teachers', 'subjects', 'absences'));
    }
    // Store schedule
public function store(Request $request)
{
    // Validate input
    $request->validate([
        'teacher_id' => 'required|exists:teachers,id',
        'status' => 'required|array',
        'subject' => 'nullable|array',
    ]);

    $teacherId = $request->input('teacher_id');
    $statusData = $request->input('status', []);
    $subjectData = $request->input('subject', []);

    // Define days and time slots
    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
    $timeSlots = ['6:00-7:00','7:00-8:00','8:15-9:15','9:15-10:15','10:15-11:15','11:15-12:15'];

    foreach ($days as $day) {
        foreach ($timeSlots as $slot) {
            $status = $statusData[$day][$slot] ?? 'Available';
            $subjectId = $subjectData[$day][$slot] ?? null;
            $subjectRoom = null;

            // If status = Available → no subject
            if (strtolower($status) === 'available') {
                $subjectId = 0;
                $subjectRoom = 'Available';
            } 
            else {
                // Get subject name based on ID
                $subject = \App\Models\Subject::find($subjectId);
                $subjectRoom = $subject ? $subject->name : 'Unknown Subject';
            }

            // Save schedule
            Schedule::create([
                'teacher_id'   => $teacherId,
                'day'          => $day,
                'time_slot'    => $slot,
                'subject_id'   => $subjectId,
                'subject_room' => $subjectRoom, // ✅ Now the actual subject name
                'is_vacant'    => strtolower($status) === 'available' ? 1 : 0,
            ]);
        }
    }

    return redirect()->route('schedules.index')->with('success', 'Schedule saved successfully.');
}


    // Edit weekly schedule
   public function editWeekly($teacherId)
{
    $teacher = Teacher::findOrFail($teacherId);
    $classes = ClassModel::all();
    $schedules = Schedule::where('teacher_id', $teacherId)->get();

    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
    $timeSlots = ['6:00-7:00','7:00-8:00','8:15-9:15','9:15-10:15','10:15-11:15','11:15-12:15'];

    // Add this line to pass all subjects
    $subjects = Subject::all();

    return view('schedules.editWeekly', compact('teacher','classes','schedules','days','timeSlots','subjects'));
}


    // Update weekly schedule
   public function updateWeekly(Request $request, $teacherId)
{
    $request->validate([
        'status' => 'required|array',
        'subject' => 'required|array',
    ]);

    $status = $request->status;
    $subjects = $request->subject;

    foreach ($status as $day => $slots) {
        foreach ($slots as $timeSlot => $value) {
            $isVacant = $value === 'Available' ? 1 : 0;

            // Only save subject if the slot is Reserved
            $subjectId = $isVacant ? null : ($subjects[$day][$timeSlot] ?? null);
            $subjectRoom = null;

            if ($subjectId) {
                $subject = Subject::find($subjectId);
                $subjectRoom = $subject ? $subject->name . ' / ' . $subject->code : null;
            }

            Schedule::updateOrCreate(
                [
                    'teacher_id' => $teacherId,
                    'day' => $day,
                    'time_slot' => $timeSlot,
                ],
                [
                    'is_vacant' => $isVacant,
                    'subject_id' => $subjectId,
                    'subject_room' => $subjectRoom,
                ]
            );
        }
    }

    return redirect()->route('schedules.index')->with('success', 'Weekly schedule updated successfully.');
}


    // Destroy
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success','Schedule deleted.');
    }

public function getSubjects($teacherId)
{
    $day = request('day');

    $schedules = Schedule::with('subject')
        ->where('teacher_id', $teacherId)
        ->where('day', $day)
        ->get(['id', 'teacher_id', 'subject_id', 'time_slot']);

    $data = $schedules->map(function ($schedule) {
        return [
            'time_slot'     => $schedule->time_slot,
            'subject_id'    => $schedule->subject_id ?? '', // <— don’t default to 0
            'subject_room'  => $schedule->subject?->name ?? 'Available',
        ];
    });

    \Log::info('Fetched schedule data:', $data->toArray()); // optional debugging

    return response()->json($data);
}


public function availableTeachers(Request $request)
{
    $day = $request->query('day');
    $time_slot = $request->query('time_slot');

    if (!$day || !$time_slot) {
        return response()->json([]);
    }

    // Get all schedules where the teacher is marked as vacant for the given day/time
    $schedules = \App\Models\Schedule::with('teacher')
        ->where('day', $day)
        ->where('time_slot', $time_slot)
        ->where('is_vacant', 1)
        ->get();

    // Map to only return teacher id and name
    $availableTeachers = $schedules->map(function($schedule) {
        return [
            'id' => $schedule->teacher->id,
            'name' => $schedule->teacher->name,
            'is_vacant' => $schedule->is_vacant,
        ];
    });

    return response()->json($availableTeachers);
}




public function getSubjectsByDay(Request $request)
{
    $day = $request->query('day');

    if (!$day) {
        return response()->json(['error' => 'Day parameter is required'], 400);
    }

    // Fetch subject_room from schedules table based on the given day
    $subjects = \App\Models\Schedule::where('day', $day)
        ->select('id', 'subject_room', 'time_slot')
        ->get();

    return response()->json($subjects);
}

public function getSubjectsByDayAndTeacher(Request $request)
{
    $day = $request->query('day');
    $absenceId = $request->query('absence_id');

    if (!$day || !$absenceId) {
        return response()->json(['error' => 'Day and absence_id are required'], 400);
    }

    // Find the teacher_id linked to this absence_id
    $absence = \App\Models\Absence::find($absenceId);
    if (!$absence) {
        return response()->json(['error' => 'Invalid absence_id'], 404);
    }

    $teacherId = $absence->teacher_id;

    // Fetch schedules for that teacher and day
    $subjects = Schedule::where('teacher_id', $teacherId)
        ->where('day', $day)
        ->select('id', 'subject_room', 'time_slot')
        ->get();

    return response()->json($subjects);
}

public function getSubjectsByTeacher($teacherId, Request $request)
{
    $day = $request->query('day');

    $schedules = \App\Models\Schedule::where('teacher_id', $teacherId)
        ->when($day, fn($q) => $q->whereRaw('LOWER(day) = ?', [strtolower($day)]))
        ->select('time_slot', 'subject_room')
        ->orderBy('time_slot')
        ->get()
        ->map(function ($item) {
            $item->subject_room = $item->subject_room ?? 'VACANT';
            return $item;
        });

    return response()->json($schedules);
}


public function getTimeSlotsByTeacherDay($teacherId, Request $request)
{
    $day = $request->query('day');

    $timeSlots = Schedule::where('teacher_id', $teacherId)
        ->when($day, fn($q) => $q->where('day', $day))
        ->select('time_slot')
        ->distinct()
        ->pluck('time_slot');

    return response()->json($timeSlots);
}
public function bulkDelete(Request $request)
{
    $ids = $request->input('selected_schedules', []);
    if (!empty($ids)) {
        Schedule::whereIn('id', $ids)->delete();
    }
    return redirect()->route('schedules.index')->with('success', 'Selected schedules deleted successfully.');
}


public function availableSubjects(Request $request)
{
    $teacherId = $request->query('teacher_id');
    $day = $request->query('day');
    $timeSlot = $request->query('time_slot');

    try {
        $subjects = Schedule::where('teacher_id', $teacherId)
            ->where('day', $day)
            ->where('time_slot', $timeSlot)
            ->with('subject')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->subject_id,
                    'name' => $s->subject->name ?? 'Available',
                    'subject_room' => $s->subject_room,
                ];
            });

        return response()->json($subjects);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
// ScheduleController.php

public function getTeacherSchedules(Request $request)
{
    $teacherId = $request->query('teacher_id');
    $day = $request->query('day');  // optional if needed
    
    $query = \DB::table('schedules')
        ->select('subject_id', 'subject_room', 'time_slot')
        ->where('teacher_id', $teacherId);

    if ($day) {
        $query->where('day', $day);
    }

    $schedules = $query->get();

    return response()->json($schedules);
}

}
