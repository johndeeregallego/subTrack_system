<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    // ✅ Make sure the model points to the correct table name
    protected $table = 'classes';

    // ✅ Match only the actual columns in your table
    protected $fillable = [
        'name',
        'description',
    ];

    // Optional relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function substitutions()
    {
        return $this->hasMany(Substitution::class, 'class_id');
    }
}
