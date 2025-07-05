<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'subtotal',
        'discount',
        'convenience_fee',
        'total_amount',
        'payment_method',
        'status', // <== PASTIKAN INI ADA DI FILLABLE
        // 'quantity',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Accessor untuk status yang lebih user-friendly (opsional)
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status); // Mengubah 'completed' menjadi 'Completed'
    }

    // Relasi ke Product
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}