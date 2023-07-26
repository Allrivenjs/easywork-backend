<?php

namespace App\Traits;

use App\Models\profile;
use App\Models\Topic;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Notification;

trait NotificateTrait
{
    public function notifyTask(): void
    {
        profile::query()->with('user')->whereHas('topics',
            fn ($q) => $q->whereIn('topics.id',
                Topic::query()->whereHas('tasks',
                    fn ($q) => $q->where('tasks.id', $this->id)
                )->pluck('id')->toArray()
            ))->get()->each(fn ($profile) => Notification::send($profile->user, new TaskNotification($this)));
    }
}
