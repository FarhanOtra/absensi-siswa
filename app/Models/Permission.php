<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','user_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class,'attendance_id','id');
    }
}
