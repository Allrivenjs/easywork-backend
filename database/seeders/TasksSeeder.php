<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\task;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    protected $topics = [
        'Matematicas',
        'Fisica',
        'Quimica',
        'Programacion',
        'Logica',
        'Diseno',
        'Negocios',
        'Estadistica',
        'Lenguas',
        'Deporte',
        'Musica'
    ];

    protected $status = [
        'Creado',
        'Publicado',
        'Por asignar',
        'Asignado',
        'En proceso',
        'Finalizado',
        'Entregado'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->topics as $key => $data){
            Topic::create([
                'name'=>$data
            ]);
        }
        foreach ($this->status as $key => $data){
            Status::create([
                'name'=>$data
            ]);
        }

        $tasks = task::factory(1)->create([
            'status_id'=>Status::all()->random()->id
        ]);

        foreach ($tasks as $task){
            $task->topics()->attach([
                rand(1,5),
                rand(6,11)
            ]);
        }



    }
}
