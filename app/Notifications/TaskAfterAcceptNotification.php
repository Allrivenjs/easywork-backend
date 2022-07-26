<?php

namespace App\Notifications;

use App\Models\task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TaskAfterAcceptNotification extends Notification implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private Task $task, private User $user, private float $charge)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'task' => $this->task,
            'user_accept' => $this->user,
            'charge' => $this->charge,
            'message' => "El usuario {$this->user->name} ha aceptado tu petición de realizar la tarea {$this->task->title} por un monto de {$this->charge}",
        ];
    }
}
