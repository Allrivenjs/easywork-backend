<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Models\user_type;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        return response([user_type::all()])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        user_type::create([
            'name' => $request->name,
        ]);

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  Request  $request
     * @param  user_type  $user_type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $user_type)
    {
        $request->validate([
            'name' => 'required',
        ]);
        user_type::query()->findOrFail($user_type)->update([
            'name' => $request->name,
        ]);

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  user_type  $user_type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($user_type)
    {
        user_type::query()->findOrFail($user_type)->delete();

        return response(null)->setStatusCode(Response::HTTP_OK);
    }
}
