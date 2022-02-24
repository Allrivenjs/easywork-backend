<?php

namespace App\Jobs;

use App\Models\task;
use App\Notifications\TaskStoreNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTaskStoredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $task;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $this->task->owner->notify(new TaskStoreNotification($this->task));
    }
}
