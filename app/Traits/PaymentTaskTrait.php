<?php

namespace App\Traits;

use App\Models\AcceptTask;
use App\Models\Pay;
use App\Models\task;
use App\Models\User;
use App\Notifications\PaymentTaskNotification;
use App\Services\MercadoPagoService;
use Illuminate\Support\Facades\Notification;

trait PaymentTaskTrait
{
    use AuthTrait;

    /**
     * @throws \Throwable
     */
    public function paymentTask(MercadoPagoService $mercadoPagoService, array $data): void
    {
        $task = task::query()->findOrFail($data['task_id']);
        $user = User::query()->findOrFail($data['user_id']);
        $acceptTask = AcceptTask::query()->findOrFail($data['accept_tasks_id']);
        throw_if($task->user_id !== $this->authApi()->id(), 'The user is not the owner of the task');
        throw_if($acceptTask->user_id !== $user->id, 'The user is not assigned to the task');
        throw_if(is_null($acceptTask->remmove_at), 'The task is already removed');
        throw_if(!is_null($acceptTask->accepted_at), 'The task is not accepted');
        throw_if($acceptTask->charge !== $data['transaction_amount'], 'The charge is not correct');
        $payment = $mercadoPagoService->payment($data);
        Pay::query()->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'accept_task_id' => $acceptTask->id,
            'paying' => $data['transaction_amount'],
            'paid_at' => now(),
            'payment_data'=>json_encode($payment),
        ]);
        $task->updateOrFail([
            'status' => task::STATUS_FINALIZADO,
            'finished_at' => now(),
        ]);
        $acceptTask->updateOrFail([
            'paid_out_at' => now(),
        ]);
        Notification::send($user, new PaymentTaskNotification($task, $data['transaction_amount']));
    }

    public function getPaymentTask(Pay $pay): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $pay->with('task','user', 'acceptTask')->paginate(10);
    }

}
