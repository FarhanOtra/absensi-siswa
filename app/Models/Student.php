<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nis',
        'name',
        'gender',
        'classroom_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function student_attendance()
    {
        return $this->belongsTo(Student_attendance::class,'user_id','student_id');
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'student_attendances','student_id','attendance_id','user_id','id');
    }
}
