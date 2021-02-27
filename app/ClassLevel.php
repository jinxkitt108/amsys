<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassLevel extends Model
{
    protected $fillable = [
        'class_level_code', 'degree', 'major', 'year', 'section', 'no_of_students'
    ];
}
