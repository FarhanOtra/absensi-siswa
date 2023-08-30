<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'holiday_group_id',
        'date',
    ];

    public function group()
    {
        return $this->belongsTo(Holiday_group::class,'holiday_group_id','id');
    }
}
