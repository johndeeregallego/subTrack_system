<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $timeSlots = [
            '6:00-7:00',
            '7:00-8:00',
            '8:15-9:15',
            '10:15-11:15',
            '11:15-12:15',
        ];

        // Make sure at least one teacher exists
        $teacher = Teacher::first();

        if (!$teacher) {
            $teacher = Teacher::create([
                'name' => 'Sample Teacher',
                'email' => 'teacher@example.com',
                'department' => 'General',
                'is_available' => true,
            ]);
        }

        foreach ($timeSlots as $slot) {
            Schedule::firstOrCreate([
                'teacher_id' => $teacher->id,
                'time_slot' => $slot,
            ], [
                'is_vacant' => true,
            ]);
        }
    }
}
