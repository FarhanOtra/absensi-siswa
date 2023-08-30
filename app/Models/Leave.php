<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_classroom_id',
        'date_start',
        'date_end',
        'type',
        'title',
        'desc',
        'attachment',
        'status',
    ];

    public function student_attendance()
    {
        return $this->belongsToMany(Student_attendance::class);
    }
}
