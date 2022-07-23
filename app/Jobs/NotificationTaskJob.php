<?php

namespace App\Jobs;

use App\Models\task;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;


class NotificationTaskJob  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private task $task){

    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->task->notifyTask();
    }
}
