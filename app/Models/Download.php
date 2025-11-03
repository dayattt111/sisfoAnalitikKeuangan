<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Download extends Model
{
    // Atribut yang boleh diisi massal
    protected $fillable = [
        'manager_id',         // foreign key ke User sebagai manager
        'financial_report_id',// foreign key ke FinancialReport
        'file_path',
        'downloaded_at'
    ];

    /**
     * Relasi: Download dimiliki oleh (belongs to) User sebagai manager.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Relasi: Download dimiliki oleh (belongs to) FinancialReport.
     */
    public function financialReport(): BelongsTo
    {
        return $this->belongsTo(FinancialReport::class);
    }
}
