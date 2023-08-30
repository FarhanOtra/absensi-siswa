<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'classroom_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','user_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class,'classroom_id','id');
    }
}