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
    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response([university::all()])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'name' => 'required',
        ]);
        university::create([
            'name' => $request->name,
        ]);

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  Request  $request
     * @param  university  $university
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $university): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'name' => 'required',
        ]);
        university::query()->findOrFail($university)->update([
            'name' => $request->name,
        ]);

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  university  $university
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($university): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        university::query()->findOrFail($university)->delete();

        return response(null)->setStatusCode(Response::HTTP_OK);
    }
}
