<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FilesSave
{

    public function saveFiles($files): void
    {
        foreach ($files as $file) {
            $this->files()->create([
                "url"=> Storage::disk('local')->put('Files/jobs', $file),
                'mime'=> $file->extension(),
                'originalName'=>  time()."_".$file->getClientOriginalName()
            ]);
        }
    }

    public function updateFiles($files, $oldFiles): void
    {
        foreach ($files as $file) {
            $this->files()->create([
                "url"=> Storage::disk('local')->put('Files/jobs', $file),
                'mime'=> $file->extension(),
                'originalName'=>  time()."_".$file->getClientOriginalName()
            ]);
        }
        foreach ($oldFiles as $file) {
            Storage::disk('local')->delete($file->url);
            $this->files()->where('id', $file->id)->delete();
        }
    }

    public function destroyFiles($files): void
    {
        foreach ($files as $file) {
            Storage::disk('local')->delete($file->url);
            $this->files()->where('id', $file->id)->delete();
        }
    }

}
