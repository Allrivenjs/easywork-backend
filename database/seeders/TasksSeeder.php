<?php

namespace Database\Seeders;

use App\Models\task;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        task::factory()->count(10000)->create()
            ->each(fn ($task) => $task->topics()->attach([rand(1, 5), rand(6, 11)]));
    }
}
