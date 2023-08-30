<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'leave_id',
    ];
}
