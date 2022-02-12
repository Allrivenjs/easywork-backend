<?php

namespace Database\Factories;

use App\Models\section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\section>
 */
class sectionsFactory extends Factory
{
    protected $model=section::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name()
        ];
    }
}
