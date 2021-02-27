<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id', 'time_in', 'time_out', 'status', 'total_hours'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
