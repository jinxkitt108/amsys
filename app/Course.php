<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'degree_id',
        'semester',
        'year_level',
        'course_code',
        'course_description',
        'units',
        'lec',
        'lab',
        'total'
    ];
}
