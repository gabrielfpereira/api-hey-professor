<?php

namespace Database\Factories;

use App\Models\{Question, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'question_id' => Question::factory(),
            'value'       => $this->faker->randomElement([1, 0]),
        ];
    }
}
