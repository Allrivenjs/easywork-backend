<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Traits\TaskTrait;
use Illuminate\Http\Request;

class AcceptTaskController extends Controller
{
    use TaskTrait;
    public function index(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'charge' => 'required',
        ]);
        $this->acceptTask($request->user_id, $request->task_id, $request->charge);
    }


}
