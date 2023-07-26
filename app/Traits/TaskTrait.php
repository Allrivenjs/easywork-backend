<?php

namespace App\Traits;

use App\Models\AcceptTask;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAfterAcceptNotification;
use Illuminate\Support\Facades\Notification;
use Throwable;

trait TaskTrait
{
    /**
     * @throws Throwable
     */
    public function beforeAcceptTask(User $user, Task $task, float $charge): void
    {
        $task->accept_tasks()->create([
            'user_id' => $user->id,
            'charge' => $charge,
        ]);
        $task->updateOrFail(['status_id' => Task::STATUS_POR_ASIGNAR]);
        Notification::sendNow($task->owner()->first(), new TaskAfterAcceptNotification($task, $user, $charge));
    }

    public function getBeforeAcceptedTasks(User $user): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return  $user->tasks()->with('accept_tasks.user')->where('status_id', Task::STATUS_POR_ASIGNAR)->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * @throws Throwable
     */
    public function declineTask(AcceptTask $acceptTask): void
    {
        throw_if(is_null($acceptTask->accepted_at), new \Exception('La tarea ya fue aceptada'));
        $acceptTask->updateOrFail([
            'remove_at' => now(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function acceptTask(AcceptTask $acceptTask): void
    {
        $acceptTask->updateOrFail([
            'accepted_at' => now(),
        ]);
        $acceptTask->task()->update(['status_id' => Task::STATUS_ASIGNADO]);
        $acceptTask->task()->update(['status_id' => Task::STATUS_EN_PROCESO]);
        Notification::sendNow($acceptTask->user()->first(), new TaskAfterAcceptNotification($acceptTask->task, $acceptTask->user, $acceptTask->charge));
    }
}
