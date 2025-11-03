<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    // Atribut yang boleh diisi massal (mass assignable)
    protected $fillable = ['user_id', 'activity', 'description'];

    /**
     * Relasi: ActivityLog dimiliki oleh (belongs to) User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
