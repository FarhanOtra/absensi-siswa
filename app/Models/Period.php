<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'semester',
        'active'
    ];

    public function year()
    {
        return $this->belongsTo(School_year::class,'school_year_id','id');
    }
}
