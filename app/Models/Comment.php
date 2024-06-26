<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    const EMPTY_UPDATE_STATUS_MESSAGE = "No comment was added";

    protected $guarded = [];
    protected $perPage = 5;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        return $this->likes->contains('user_id', $user->id);
    }

    public function like(User $user)
    {
        $this->likes()->create([
            'user_id' => $user->id,
        ]);
    }

    public function unLike(User $user)
    {
        $this->likes()->where('user_id', $user->id)->delete();
    }
}
