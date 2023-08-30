<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'student_classroom_id',
        'status',
        'time_in',
        'modified_by',
        'notes'
    ];

    public function student_classroom()
    {
        return $this->belongsTo(Student_classroom::class,'student_classroom_id','id');
    }

    public function modified()
    {
        return $this->belongsTo(User::class,'modified_by','id');
    }

    public function leave()
    {
        return $this->belongsToMany(Leave::class, 'leave_id');
    }
}
