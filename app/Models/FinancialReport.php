<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialReport extends Model
{
    // Atribut yang boleh diisi massal
    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'status',
        'validated_by',
        'validated_at',
        'komentar_manager',
        'komentar_admin',
        // Old columns (deprecated but kept for backward compatibility)
        'judul',
        'deskripsi',
        'periode_mulai',
        'periode_akhir'
    ];

    /**
     * Relasi: FinancialReport dimiliki oleh (belongs to) User (staff yang membuat).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias untuk backward compatibility
     */
    public function staff(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Relasi: FinancialReport dimiliki oleh (belongs to) User sebagai validator.
     */
    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Relasi: FinancialReport memiliki banyak (hasMany) Transaction.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi: FinancialReport memiliki banyak (hasMany) Download.
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }
}
