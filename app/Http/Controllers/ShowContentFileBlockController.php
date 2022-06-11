<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ShowContentFileBlockController extends Controller
{
    public function getImagePath(Request $request){

        $path = storage_path('app/public/'.$request->input('path'));
        abort_if(!File::exists($path), 404);
        $file = File::get($path);
        $type = File::extension($path);

        $response = Response::make(base64_decode($file), 200);
        //a
        //a
        $response->header("Content-Type", $type);

        return $response;
    }

    public function getVideoPath(Request $request){
//        dd($request->input('path'));
        $path = storage_path('app/public/'.$request->input('path'));
        abort_if(!File::exists($path), 404);
        $headers = [
            'Content-Type'        => 'video/'.File::extension($path),
            'Content-Length'      => File::size($path),
            'Content-Disposition' => 'attachment; filename="' .File::name($path) . '"'
        ];
        return Response::stream(function () use ($path){
            try {
                $stream = fopen($path, 'r');
                fpassthru($stream);
            }catch (\Exception $exception){
                Log::error($exception);
            }
        }, 200, $headers);
    }
}
