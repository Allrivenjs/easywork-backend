<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicAndStatusSeeder extends Seeder
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
        'Musica',
    ];

    protected $status = [
        'Creado',
        'Publicado',
        'Por asignar',
        'Asignado',
        'En proceso',
        'Finalizado',
        'Entregado',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->topics)->each(fn ($topic) => Topic::create(['name' => $topic]));
        collect($this->status)->each(fn ($status) => Status::create(['name' => $status]));
    }
}
