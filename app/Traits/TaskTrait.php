<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Task;
use App\Notifications\TaskAcceptNotification;
use Illuminate\Support\Facades\Notification;

trait TaskTrait
{

    /**
     * @throws \Throwable
     */
    public function acceptTask(User $user, Task $task, float $charge): void
    {
        $task->accept_tasks()->create([
            'user_id' => $user->id,
            'charge' => $charge,
        ]);
        $task->updateOrFail(['status_id'=> Task::STATUS_POR_ASIGNAR]);
        Notification::sendNow($task->owner()->first(), new TaskAcceptNotification($task, $user, $charge));
    }
}
