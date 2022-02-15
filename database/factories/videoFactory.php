<?php

namespace Database\Factories;

use App\Models\video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\video>
 */
class videoFactory extends Factory
{
    protected $model=video::class;
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
            'url'=>env('APP_URL').'/storage/Images/courses/'.$this->faker->image('public/storage/Images/courses', 640,480, 'null', false),
            'description'=>$this->faker->text(300)
        ];
    }
}
