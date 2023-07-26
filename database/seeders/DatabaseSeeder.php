<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TopicAndStatusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            //            CourseSeeder::class,
            TasksSeeder::class,
            CountriesSeeder::class,
        ]);
    }
}
