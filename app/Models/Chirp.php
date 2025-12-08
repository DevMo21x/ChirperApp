<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chirp extends Model
{
    protected $fillable = [
        'message'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(related: Like::class);
    }

    public function isLikedBy(User $user): bool
    {
        // Check if authenticated user has liked this chirp or not: bool
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function isBookmarkedBy(User $user): bool 
    {
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }
}
