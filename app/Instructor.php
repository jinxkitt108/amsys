<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'status',
        'work_status',
        'remarks'
    ];

    protected $with = [
        "employee"
    ];

    public function employee()
    {
        return $this->morphOne('App\Employee', 'employeable');
    }
}
