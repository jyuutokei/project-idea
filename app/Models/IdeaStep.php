<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $App\Models\Idea
 * @property string $description
 * @property int $completed
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Idea|null $idea
 * @method static \Database\Factories\IdeaStepFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep whereApp\Models\Idea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdeaStep whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IdeaStep extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaStepFactory> */
    use HasFactory;

    protected $attributes = [
        'completed' => false
    ];

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
