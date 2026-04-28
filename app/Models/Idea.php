<?php

namespace App\Models;

use App\IdeaStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $App\Models\User
 * @property string $title
 * @property string|null $description
 * @property IdeaStatus $status
 * @property string|null $image_path
 * @property \Illuminate\Database\Eloquent\Casts\ArrayObject<array-key, mixed> $links
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IdeaStep> $steps
 * @property-read int|null $steps_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\IdeaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereApp\Models\User($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'status' => IdeaStatus::class
    ];

    protected $attributes = [
        'status' => IdeaStatus::PENDING->value
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(IdeaStep::class);
    }
}
