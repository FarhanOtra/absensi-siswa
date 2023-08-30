<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'date',
        'time',
        'time_limit',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class,'period_id','id');
    }

    public function student_attendance()
    {
        return $this->hasMany(Student_attendance::class,'attendance_id','id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_attendances','attendance_id','student_id','id','user_id');
    }

}
    