<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'action', 'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];
}