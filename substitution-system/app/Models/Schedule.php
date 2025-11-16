<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
    'teacher_id',
    'day',
    'time_slot',
    'is_vacant',
    'subject_id',
    'subject_room',
];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

// app/Models/Schedule.php
public function subject()
{
    return $this->belongsTo(\App\Models\Subject::class);
}


}
