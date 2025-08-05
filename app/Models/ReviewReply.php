<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReviewReply extends Model
{
    protected $fillable = [
        'review_id',
        'user_id',
        'reply',
        'parent_id',
    ];

    /**
     * The user who wrote this reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The review this reply belongs to.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * The parent reply (if this is a nested reply).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ReviewReply::class, 'parent_id');
    }

    /**
     * Replies to this reply (nested replies).
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ReviewReply::class, 'parent_id');
    }
}
