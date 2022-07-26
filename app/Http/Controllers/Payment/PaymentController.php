<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\MercadoPagoService;
use App\Traits\PaymentTaskTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use PaymentTaskTrait;

    /**
     * @throws \Throwable
     */
    public function pay(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate(
            self::rules(MercadoPagoService::Rules())
        );
        $this->paymentTask(new MercadoPagoService(), $data);
        return response(null);
    }


    static function rules($oldRules): array
    {
        return array_merge($oldRules, [
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'accept_tasks_id' => 'required|exists:accept_tasks,id',
        ]);
    }
}
