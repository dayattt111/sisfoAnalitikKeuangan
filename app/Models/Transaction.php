<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'financial_report_id',
        'user_id',
        'jenis',
        'jumlah',
        'keterangan',
        'tanggal'
    ];

    public function financialReport(): BelongsTo
    {
        return $this->belongsTo(FinancialReport::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
