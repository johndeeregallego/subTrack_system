<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substitution extends Model
{
    use HasFactory;

protected $fillable = [
    'absence_id',
    'teacher_id',
    'time_slot',
    'subject_id',
    'substitute_id',
    'start_date',
    'end_date',
    'day',
    'date', // ✅ Added here
    'status',
];




    // Original absent teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // Assigned substitute teacher
    public function substitute()
    {
        return $this->belongsTo(Teacher::class, 'substitute_id');
    }

    // Related absence
    public function absence()
    {
        return $this->belongsTo(Absence::class, 'absence_id');
    }
    public function subject()
{
    return $this->belongsTo(Subject::class, 'subject_id');
}

}
