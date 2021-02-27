<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_id', 'employeable_type', 'employeable_id'
    ];

    public function employeable()
    {
        return $this->morphTo();
    }
}
