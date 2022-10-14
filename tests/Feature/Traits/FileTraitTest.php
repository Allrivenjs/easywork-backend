<?php

namespace Traits;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTraitTest extends TestCase
{
    public function testGetPublicImages()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $filePut = str_replace('public/', '', Storage::disk('public')->put('', $file));
        $response = $this->get(route('getAnyImage', ['type' => 'public', 'path' => $filePut]));
        $this->assertEquals(200, $response->getStatusCode());
        Storage::disk('public')->delete($filePut);
    }

    public function testGetPrivateImages()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $filePut = str_replace('private/', '', Storage::disk('private')->put('', $file));
        $response = $this->actingAs(User::factory()->makeOne())
            ->get(route('getAnyImage', ['type' => 'private', 'path' => $filePut]));
        $this->assertEquals(200, $response->getStatusCode());
        Storage::disk('private')->delete($filePut);
    }
}
