<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AuthTrait;

    public function getAnyFile(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $request->validate([
            'path' => 'required|string',
            'name' => 'required|string',
        ]);

        return Storage::download($request->query('path'), $request->query('name'));
    }
}
