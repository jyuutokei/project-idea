<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
