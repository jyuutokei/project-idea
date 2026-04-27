<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\IdeaStep;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IdeaStep>
 */
class IdeaStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idea_id' => Idea::factory(),
            'description' => fake()->sentence(),
            'completed' => false
        ];
    }
}
