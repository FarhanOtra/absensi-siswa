<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'student_id',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','user_id');
    }
}
