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
        Storage::deleteDirectory('Images/users');
        Storage::makeDirectory('Images/users');

        Storage::deleteDirectory('Images/profiles');
        Storage::makeDirectory('Images/profiles');

        Storage::deleteDirectory('Images/courses');
        Storage::makeDirectory('Images/courses');

        Storage::deleteDirectory('Images/temp');
        Storage::makeDirectory('Images/temp');

        Storage::deleteDirectory('Courses/videos');
        Storage::makeDirectory('Courses/videos');

        Storage::deleteDirectory('Files/jobs');
        Storage::makeDirectory('Files/jobs');


        // \App\Models\User::factory(10)->create();
        $this->call([
            TopicAndStatusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            TasksSeeder::class,

        ]);
    }
}
