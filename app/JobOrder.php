<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'status',
        'position_title',
        'remarks'
    ];

    protected $with = [
        'employee'
    ];

    public function employee()
    {
        return $this->morphOne('App\Employee', 'employeable');
    }
}
