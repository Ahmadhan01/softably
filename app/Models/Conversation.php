<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    protected $fillable = ['user1_id','user2_id'];

    /* relasi dua arah */
    public function user1(): BelongsTo { return $this->belongsTo(User::class,'user1_id'); }
    public function user2(): BelongsTo { return $this->belongsTo(User::class,'user2_id'); }

    /* koleksi peserta (helper) */
    public function getParticipantsAttribute()
    {
        return collect([$this->user1_id, $this->user2_id]);
    }

    /* accessor user lawan bicara */
    public function otherUser(int $authId, array $columns = ['*'])
    {
        return $this->user1_id == $authId ? $this->user2()->select($columns)->first()
                                          : $this->user1()->select($columns)->first();
    }

    /* relasi pesan */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('id');
    }

    
}