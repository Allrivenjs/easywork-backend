<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        $users = collect(User::all()->modelKeys());
        $status = collect(Status::all()->modelKeys());
        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(10),
            'description' => $this->faker->text(250),
            'difficulty' => $this->faker->randomElement(['easy', 'easy-medium', 'medium', 'medium-hard', 'hard']),
            'own_id' => $users->random(),
            'status_id' => $status->random(),
        ];
    }
}
