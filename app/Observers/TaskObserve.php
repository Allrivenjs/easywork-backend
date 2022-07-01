<?php

namespace App\Observers;

use App\Jobs\SendTaskStoredJob;
use App\Models\task;
use Illuminate\Support\Str;


class TaskObserve
{
    /**
     * Handle the task "created" event.
     *
     * @param task $task
     * @return void
     */
    public function created(task $task)
    {
        $task->status_id = 2;
        dispatch(new SendTaskStoredJob($task));
    }

    /**
     * Handle the task "creating" event.
     * @param task $task
     * @return void
     */
    public function creating(task $task){
        if(!\App::runningInConsole()) {
            $task->slug = Str::uuid();
            $task->status_id = 1;
            $task->own_id = Auth()->guard('web')->user()->getAuthIdentifier();
        }
    }

    /**
     * Handle the task "updated" event.
     *
     * @param task $task
     * @return void
     */
    public function updated(task $task)
    {
        //
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param task $task
     * @return void
     */
    public function deleted(task $task)
    {
        //
    }

    /**
     * Handle the task "restored" event.
     *
     * @param task $task
     * @return void
     */
    public function restored(task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param task $task
     * @return void
     */
    public function forceDeleted(task $task)
    {
        //
    }
}
