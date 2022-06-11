<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user= User::create([
            'name' => 'Admin',
            'lastname' => 'Ruiz',
            'phone' => '0007',
            'birthday'=> '0001-01-01',
            'email' => 'admin@gmail.com',
            'password' => '$2a$10$7oMxkBuQ0PpbVxpJl0ufNerj0TTuZmRxrD76LlyKCaMCh8bpZqVS2',   //admin
        ])->assignRole('admin');
        $user->assignRole('moderator');
        $user->assignRole('professor');
        $user->assignRole('worker');
        $user->profile()->update([
            'ranking'=>'5',
            'about'=>'Ando por ahí, con los de siempre en un flow cabrón. Dando vuelta en un makinón! Hola, Soy Sebastián. Amante de la musica, la tecnologia y los juegos. Un gusto. Larga vida al iguanito!
                      Ando por ahí, con los de siempre en un flow cabrón. Dando vuelta en un makinón! Hola, Soy Sebastián. Amante de la musica, la tecnologia y los juegos. Un gusto. Larga vida al iguanito!',
        ]);

        $user2= User::create([
            'name' => 'Student',
            'lastname' => 'Sanchez',
            'phone' => '0007',
            'birthday'=> '0001-01-01',
            'email' => 'student@gmail.com',
            'password' => '$2a$10$7oMxkBuQ0PpbVxpJl0ufNerj0TTuZmRxrD76LlyKCaMCh8bpZqVS2',   //admin
        ])->assignRole('student');


        $user2->profile()->update([
            'ranking'=>'4',
            'about'=>'Ando por ahí, con los de siempre en un flow cabrón. Dando vuelta en un makinón! Hola, Soy Sebastián. Amante de la musica, la tecnologia y los juegos. Un gusto. Larga vida al iguanito!
                      Ando por ahí, con los de siempre en un flow cabrón. Dando vuelta en un makinón! Hola, Soy Sebastián. Amante de la musica, la tecnologia y los juegos. Un gusto. Larga vida al iguanito!',
        ]);
    }
}
