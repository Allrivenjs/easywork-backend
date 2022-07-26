<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\task;
use App\Models\User;
use App\Traits\TaskTrait;
use Illuminate\Http\Request;

class AcceptTaskController extends Controller
{
    use TaskTrait;

    /**
     * @throws \Throwable
     */
    public function index(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'charge' => 'required',
        ]);
        $this->acceptTask(User::find($data['user_id']), task::find($data['task_id']), $data['charge']);
        return response(null);
    }


}
