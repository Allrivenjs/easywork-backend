<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(){
        $user =auth()->user();
        return response([$user->profile])->setStatusCode(Response::HTTP_OK);
    }
}
