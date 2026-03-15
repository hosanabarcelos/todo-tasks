<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'done' => fake()->boolean(20),
        ];
    }

    public function done(): static
    {
        return $this->state(fn () => ['done' => true]);
    }

    public function pending(): static
    {
        return $this->state(fn () => ['done' => false]);
    }
}
