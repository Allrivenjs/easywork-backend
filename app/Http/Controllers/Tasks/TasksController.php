<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowTasksResource;
use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Create system show tasks, topics relevant, and show for event


        //Show basic task
        return response([
            ShowTasksResource::collection(task::query()->with('topics','owner')
                ->whereHas('status',)
                ->paginate($request->input('num')?? 5))
                ->response()->getData(true)
        ])->setStatusCode(Response::HTTP_OK);
    }


    private function rules(){
        return [
            'name' => 'required',
            'description' => 'required',
            'difficulty'=>[Rule::in(['easy','easy-medium','medium','medium-hard','hard'])],
            'status'=>'exists:App\Models\Status,id'
        ];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(task $task)
    {
        //
    }
}
