<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = [
        'code', 'description', 'major', 'college_code', 'college_id'
    ];

    protected $with = [
        'courses'
    ];

    //College Relationship
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    //Courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
