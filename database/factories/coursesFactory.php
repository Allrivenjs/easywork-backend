<?php

namespace Database\Factories;

use App\Models\course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\course>
 */
class coursesFactory extends Factory
{
    protected $model=course::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name=$this->faker->name();
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'description'=>$this->faker->text(500),
        ];
    }
}
