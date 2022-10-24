<?php

namespace Tests\Feature\Http\Controllers\Profiles;

use App\Console\Commands\universities;
use App\Http\Controllers\Profiles\UniversityController;
use App\Models\university;
use Tests\TestCase;

class UniversityControllerTest extends TestCase
{

    public function testStore()
    {
        $this->withoutExceptionHandling();
        $this->post(route('university.store'), [
            'name' => 'test',
        ])->assertStatus(200);
        university::query()->where('name', 'test')->delete();
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $university = university::query()->create([
            'name' => 'test',
        ]);
        $this->delete(route('university.destroy', $university->id))->assertStatus(200);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $university = university::query()->create([
            'name' => 'test',
        ]);
        $this->put(route('university.update', $university->id), [
            'name' => 'test2',
        ])->assertStatus(200);
        university::query()->where('name', 'test2')->delete();
    }

    public function testIndex()
    {
        $this->withoutExceptionHandling();
        $this->get(route('university.index'))->assertStatus(200);
    }
}
