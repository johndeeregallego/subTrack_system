<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassModelController extends Controller
{
    // Display all classes
    public function index()
    {
        $classes = ClassModel::all();
        return view('classes.index', compact('classes'));
    }

    // Show create form
    public function create()
    {
       $teachers = \App\Models\Teacher::all(); // Fetch all teachers
    return view('classes.create', compact('teachers'));
    }

    // Store new class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        ClassModel::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    // Update existing class
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    // Delete class
    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
