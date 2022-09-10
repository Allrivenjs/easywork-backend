<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TasksSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect(User::all()->modelKeys());
        $status = collect(Status::all()->modelKeys());
        $tasks = [];
        $name = fake()->name();
        for ($i = 0; $i < 50000; $i++) {
            $tasks[] = [
                'name' => $name,
                'slug' => Str::slug($name).'-'.Str::random(10),
                'description' => fake()->text(250),
                'difficulty' => fake()->randomElement(['easy', 'easy-medium', 'medium', 'medium-hard', 'hard']),
                'own_id' => $users->random(),
                'status_id' => $status->random(),
            ];
        }

        foreach (array_chunk($tasks, 1000) as $chunk) {
             task::insert($chunk);
        }



    }
}
