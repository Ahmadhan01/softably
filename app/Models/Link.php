<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'user_id',
        'status', // active, blocked, etc.
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
