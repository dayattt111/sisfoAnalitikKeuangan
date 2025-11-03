<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    // Atribut yang boleh diisi massal
    protected $fillable = [
        'financial_report_id', // foreign key ke FinancialReport
        'description',
        'amount',
        'transaction_date'
    ];

    /**
     * Relasi: Transaction dimiliki oleh (belongs to) FinancialReport.
     */
    public function financialReport(): BelongsTo
    {
        return $this->belongsTo(FinancialReport::class);
    }
}
