<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\task;
use App\Models\User;
use App\Traits\TaskTrait;
use Illuminate\Http\Request;
use Throwable;

class AcceptTaskController extends Controller
{
    use TaskTrait;

    public function index(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response($this->getBeforeAcceptedTasks($request->user()));
    }

    /**
     * @throws Throwable
     */
    public function beforeAccept(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'charge' => 'required',
        ]);
        $this->beforeAcceptTask(User::find($data['user_id']), task::find($data['task_id']), $data['charge']);

        return response(null);
    }

    /**
     * @throws Throwable
     */
    public function decline(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            'accept_task_id' => 'required|exists:accept_tasks,id',
        ]);
        $this->declineTask(self::getAcceptTask($request, $data['accept_task_id']));

        return response(null);
    }

    /**
     * @throws Throwable
     */
    public function accept(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            'accept_task_id' => 'required|exists:accept_tasks,id',
        ]);
        $this->acceptTask(self::getAcceptTask($request, $data['accept_task_id']));

        return response(null);
    }

    public static function getAcceptTask(Request $request, $accept_task_id)
    {
        return $request->user()->accept_tasks()->findOrFail($accept_task_id);
    }
}
