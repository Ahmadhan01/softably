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
        // Ganti 'reference_id' dengan 'transaction_id' jika Anda melakukan perubahan migrasi
        'transaction_id',
        'reference_id', // Pertahankan jika reference_id punya tujuan lain
    ];

    /**
     * Get the user that owns the SoftPay transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ke Transaction utama
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}