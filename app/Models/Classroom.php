<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade',
        'teacher_id',
        'school_year_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id','user_id');
    }

    public function year()
    {
        return $this->belongsTo(School_year::class,'school_year_id','id');
    }
}
