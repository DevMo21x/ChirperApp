<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    // These fields can be saved to the database
    protected $fillable = [
        'user_id',
        'chirp_id',
    ];

    // Each bookmark belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Each bookmark belongs to one chirp
    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }
}
