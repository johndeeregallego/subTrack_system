<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    TeacherController,
    ClassModelController,
    AbsenceController,
    SubstitutionController,
    ScheduleController,
    SubjectController
};

// =======================
// 📊 Dashboard
// =======================
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// =======================
// 👩‍🏫 Teachers CRUD + AJAX
// =======================
Route::resource('teachers', TeacherController::class);
Route::get('/teachers/{teacher}/department', [TeacherController::class, 'getDepartment'])
    ->name('teachers.department');

// =======================
// 🏫 Classes CRUD
// =======================
Route::resource('classes', ClassModelController::class);

// =======================
// 🚫 Absences CRUD + AJAX
// =======================
Route::resource('absences', AbsenceController::class);
Route::get('/absences/{teacher}/date', [AbsenceController::class, 'getDate'])
    ->name('absences.date');
Route::get('/schedules/available-teachers', [ScheduleController::class, 'availableTeachers']);

// =======================
// 📚 Subjects CRUD
// =======================
Route::resource('subjects', SubjectController::class);
Route::get('/schedules/timeslots/{teacherId}', [App\Http\Controllers\ScheduleController::class, 'getTimeSlotsByTeacherDay']);

// =======================
// 🗓️ Schedules - AJAX
// =======================
Route::get('/schedules/subjects/{teacherId}', [App\Http\Controllers\ScheduleController::class, 'getSubjectsByTeacher']);

// Get subjects by teacher & day
Route::get('/schedules/subjects-by-day-teacher', [ScheduleController::class, 'getSubjectsByDayAndTeacher'])
    ->name('schedules.subjectsByDayTeacher');

// Get subjects by day only
Route::get('/schedules/subjects-by-day', [ScheduleController::class, 'getSubjectsByDay'])
    ->name('schedules.subjectsByDay');

// Get available teachers
Route::get('/schedules/available-teachers', [ScheduleController::class, 'availableTeachers'])
    ->name('schedules.availableTeachers');

// Get all subjects (generic)
Route::get('/schedules/subjects', [ScheduleController::class, 'getSubjects'])
    ->name('schedules.subjects');

// 🗓️ Schedules CRUD + Toggle + Weekly Edit
Route::resource('schedules', ScheduleController::class);
Route::patch('/schedules/{schedule}/toggle', [ScheduleController::class, 'toggle'])->name('schedules.toggle');
Route::get('/schedules/{teacher}/edit-weekly', [ScheduleController::class, 'editWeekly'])->name('schedules.editWeekly');
Route::put('/schedules/{teacher}/update-weekly', [ScheduleController::class, 'updateWeekly'])->name('schedules.updateWeekly');

// Bulk delete schedules
Route::delete('/schedules/bulk-delete', [ScheduleController::class, 'bulkDelete'])
    ->name('schedules.bulkDelete');



// AJAX routes for substitutions
Route::prefix('substitutions')->name('substitutions.')->group(function () {
    Route::get('/subjects', [SubstitutionController::class, 'getSubjects'])->name('subjects');
    Route::get('/subjects-by-teacher', [SubstitutionController::class, 'getSubjectsByTeacher'])->name('subjects.byTeacher');
    Route::get('/available-teachers', [SubstitutionController::class, 'availableTeachers'])->name('available-teachers');
});

// Standard CRUD
Route::resource('substitutions', SubstitutionController::class);
Route::get('/schedules/available-subjects', [ScheduleController::class, 'availableSubjects']);

// Bulk delete substitutions
Route::delete('/substitutions/bulk-delete', [SubstitutionController::class, 'bulkDelete'])
    ->name('substitutions.bulkDelete');

    // routes/web.php
Route::get('/api/teacher-schedules', [ScheduleController::class, 'getTeacherSchedules']);
Route::delete('/substitutions/bulk-delete', [SubstitutionController::class, 'bulkDelete'])->name('substitutions.bulkDelete');

