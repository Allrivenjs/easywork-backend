<?php

namespace App\Observers;

use App\Models\task;
use Illuminate\Support\Str;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Models\task  $task
     * @return void
     */
    public function created(task $task)
    {
        if (! \App::runningInConsole()) {
            $task->status_id = task::STATUS_PUBLICADO;
        }
    }

    /**
     * Handle the task "creating" event.
     *
     * @param  task  $task
     * @return void
     */
    public function creating(task $task)
    {
        if (! \App::runningInConsole()) {
            $task->slug = Str::uuid();
            $task->status_id = task::STATUS_CREATED;
            $task->own_id = Auth()->guard('api')->user()->getAuthIdentifier();
        }else{
            $task->topics()->attach([rand(1, 5), rand(6, 11)]);
        }

    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Models\task  $task
     * @return void
     */
    public function updated(task $task)
    {
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Models\task  $task
     * @return void
     */
    public function deleted(task $task)
    {
        //
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \App\Models\task  $task
     * @return void
     */
    public function restored(task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \App\Models\task  $task
     * @return void
     */
    public function forceDeleted(task $task)
    {
        //
    }
}
