<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionTemplate extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'amount',
        'type',
        'icon',
    ];

    /**
     * Relasi ke model User (Pemilik template)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Category (Kategori transaksi)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function transactionTemplate()
    {
        return $this->hasMany(Transaction::class);
    }
}
