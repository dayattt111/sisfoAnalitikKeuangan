<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialReport extends Model
{
    // Atribut yang boleh diisi massal
    protected $fillable = [
        'staff_id',      // foreign key ke User sebagai staff
        'validator_id',  // foreign key ke User sebagai validator
        'title', 
        'period', 
        'amount'
    ];

    /**
     * Relasi: FinancialReport dimiliki oleh (belongs to) User sebagai staff.
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Relasi: FinancialReport dimiliki oleh (belongs to) User sebagai validator.
     * Method dinamai `validatedBy` untuk menunjukkan pengguna yang memvalidasi laporan.
     */
    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validator_id');
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
