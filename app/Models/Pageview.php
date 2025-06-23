<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pageview extends Model
{

   

    protected $fillable = [
        'ip_address',
        'user_agent',
        'user_id',
        'path',
        'viewed_at',
    ];

    protected $dates = ['viewed_at'];
}

