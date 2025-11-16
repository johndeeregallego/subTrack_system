<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        return view('teachers.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email',
            'department' => 'nullable|string|max:255',
            'status'     => 'required|in:available,absent',
        ]);

        // Map status to boolean fields
        $validated['is_available'] = $validated['status'] === 'available';
        $validated['is_absent']    = $validated['status'] === 'absent';
        unset($validated['status']);

        Teacher::create($validated);

        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher added successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $classes = ClassModel::all();
        return view('teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email,' . $teacher->id,
            'department' => 'nullable|string|max:255',
            'status'     => 'required|in:available,absent',
        ]);

        $validated['is_available'] = $validated['status'] === 'available';
        $validated['is_absent']    = $validated['status'] === 'absent';
        unset($validated['status']);

        $teacher->update($validated);

        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher deleted successfully.');
    }
}
