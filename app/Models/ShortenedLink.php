<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortenedLink extends Model
{
    protected $fillable = [
        'user_id',
        'original_url',
        'code',
        'clicks',
    ];

    protected $casts = [
        'clicks' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}