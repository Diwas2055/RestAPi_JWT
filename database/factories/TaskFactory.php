<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(['active','inactive']),
            'started_at' => $this->faker->dateTimeBetween('-1 years', '+1 years')->format('Y-m-d'),
            'user_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
