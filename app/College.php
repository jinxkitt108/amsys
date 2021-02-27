<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = [
        'code', 'description', 'color_code', 'no_of_degrees'
    ];

    protected $with = ['degrees'];

    public function degrees()
    {
        return $this->hasMany(Degree::class, 'college_id');
    }
}
