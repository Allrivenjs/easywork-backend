<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Models\university;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UniversityController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(){
        return response([university::all()])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'name'=>'required'
        ]);
        university::create([
            'name'=> $request->name
        ]);
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param university $university
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $university){

        $request->validate([
            'name'=>'required'
        ]);
        university::query()->findOrFail($university)->update([
            'name'=>$request->name
        ]);
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param university $university
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($university){
        university::query()->findOrFail($university)->delete();
        return response([])->setStatusCode(Response::HTTP_OK);
    }
}
