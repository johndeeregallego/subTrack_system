<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department',
        'is_available',
        'is_absent',
        'class_id',
    ];

    /**
     * 🔹 A teacher may have multiple absences.
     */
    public function absences()
    {
        return $this->hasMany(Absence::class);
        
    }

    /**
     * 🔹 Each teacher belongs to a class (if assigned).
     */
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * 🔹 Substitutions where the teacher acts as the substitute.
     */
    public function substitutionsAsSubstitute()
    {
        return $this->hasMany(Substitution::class, 'substitute_id');
    }

    /**
     * 🔹 Substitutions where the teacher is the one being substituted (absent).
     */
    public function substitutionsAsAbsent()
    {
        return $this->hasMany(Substitution::class, 'teacher_id');
    }

    /**
     * 🔹 A teacher can have multiple schedules.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }

    /**
     * 🔹 Convenience: Get the teacher’s full availability status.
     */
    public function getStatusAttribute()
    {
        if ($this->is_absent) {
            return 'Absent';
        }

        return $this->is_available ? 'Available' : 'Unavailable';
    }
    // app/Models/Teacher.php

public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id');
}


}
