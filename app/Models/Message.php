<?php

namespace App\Models;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'conversation_id', 'content'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class,'sender_id');
    }

            public function receiver()
            {
                return $this->belongsTo(User::class, 'receiver_id');
            }
        }
        