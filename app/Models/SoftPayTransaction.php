<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoftPayTransaction extends Model
{
    use HasFactory;

    protected $table = 'soft_pay_transactions';

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'status',
        'reference_id',
    ];

    /**
     * Get the user that owns the SoftPay transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}