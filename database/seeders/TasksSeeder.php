<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\task;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        task::factory()->count(100)->create(['status_id'=> rand(1,7) ])
            ->each(fn ($task) =>
            $task->topics()->attach([rand(1,5), rand(6,11)]));
    }
}
