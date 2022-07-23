<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreResquest;
use App\Http\Resources\ShowTasksResource;
use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','getTasksForSlug');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response([
            ShowTasksResource::collection(task::with([
                'topics','owner','files',
                'status_last',
                'comments_lasted'=>[
                    'owner',
                    'replies'=>[
                        'owner',
                    ],
                ]])
                ->whereHas('status', function ($query){
                    $query->whereIn('name', ['Creado', 'Publicado', 'Por asignar']);
                })
                ->orderBy('created_at', 'desc')
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
        $task = task::with(['files','topics','owner',
            'status_last',
            'comments_lasted'=>[
                'owner',
                'replies'=>[
                    'owner',
                ],
            ]])
            ->where('slug','LIKE', $task)
            ->firstOrFail();
        return response([
            new  ShowTasksResource($task),
        ])->setStatusCode(Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreResquest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreResquest $request): \Illuminate\Http\Response
    {
        $task = task::query()->create($request->all());
        $task->topics()->attach(json_decode($request->input('topics')));
        !$request->hasFile('files') ?: $task->saveFiles($request->file('files'));
        return response(null);
    }

    public function destroy(task $task): \Illuminate\Http\Response
    {
        $task->softDeletes();
        return response(null);
    }

    public function update(TaskStoreResquest $request, task $task): \Illuminate\Http\Response
    {
        $task->update($request->all());
        $task->topics()->sync(json_decode($request->input('topics')));
        !$task->files()->exists() ?:$task->updateFiles($request->file('files'), $task->files) ;
        !$request->hasFile('files') ?: $task->saveFiles($request->file('files'));
        return response(null);
    }


}
