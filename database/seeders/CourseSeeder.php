<?php

namespace Database\Seeders;

use App\Models\course;
use App\Models\Image;
use App\Models\section;
use App\Models\User;
use App\Models\video;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::query()->first();
        $courses = course::factory(3)->create([
            'owner' => $admin->id,
        ]);

        foreach ($courses as $course) {
            Image::factory(1)->create([
                'imageable_id' => $course->id,
                'imageable_type' => course::class,
            ]);
            $sections = section::factory(5)->create([
                'course_id' => $course->id,
            ]);
            foreach ($sections as $section) {
                $videos = video::factory(8)->create([
                    'section_id' => $section->id,
                ]);
                foreach ($videos as $video) {
                    Image::factory(1)->create([
                        'imageable_id' => $video->id,
                        'imageable_type' => video::class,
                    ]);
                }
            }
        }
    }
}
