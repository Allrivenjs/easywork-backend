<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
{
    //Comentado para que no se muestre el mensaje de error

    public function __construct()
    {
        $this->middleware('can:taskAdmin.task')->except('index', 'show');
        $this->middleware('auth:api')->except('index');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        return response([Status::all()])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'name'
        ]);
        Status::create([$request->input('name')]);
        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        return response([$status])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $request->validate([
            'name'
        ]);
        $status->update([$request->input('name')]);
        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Status $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return response(null)->setStatusCode(Response::HTTP_OK);
    }
}
