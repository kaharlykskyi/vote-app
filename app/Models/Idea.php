<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function isVotedByUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    public function vote(User $user): void
    {
        if ($this->isVotedByUser($user)) {
            Vote::where('user_id', $user->id)
                ->where('idea_id', $this->id)
                ->first()
                ->delete();
        } else {
            Vote::create([
                'idea_id' => $this->id,
                'user_id' => $user->id
            ]);
        }
    }

    public function removeVote(User $user): void
    {
        Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->first()
            ->delete();
    }
}
