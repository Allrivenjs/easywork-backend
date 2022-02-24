<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreResquest;
use App\Http\Resources\ShowTasksResource;
use App\Jobs\SaveFileTaskJob;
use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ShowTasksResource::collection(task::query()->with(['topics','owner', 'status', 'files'])
                ->whereHas('status', function ($query){
                    $query->whereIn('name', ['Creado', 'Publicado', 'Por asignar']);
                })
                ->orderByDesc('id')
                ->paginate($request->input('num')?? 5))
                ->response()->getData(true)
        ])->setStatusCode(Response::HTTP_OK);
    }


    /**
     * @param $task
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getTasksForSlug($task): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        return response([
            new  ShowTasksResource(task::query()->with(['files','topics','owner', 'status'])
                ->where('slug','LIKE', $task)
                ->orWhereHas('status', function ($query){
                    $query->whereIn('name', ['Creado', 'Publicado', 'Por asignar']);
                })->firstOrFail())
        ])->setStatusCode(Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreResquest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreResquest $request)
    {
        $task = task::create($request->all());
        $task->topics()->attach(json_decode($request->input('topics')));
        if ($request->hasFile('files')){
            foreach ($request->file('files') as $item){
                $task->files()->create([
                    "url"=> Storage::disk('public')->put('Files/jobs', $item),
                    'mime'=> $item->extension()
                ]);
            }
        }
        return response([])->setStatusCode(Response::HTTP_OK);
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
     * @param Request $request
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
