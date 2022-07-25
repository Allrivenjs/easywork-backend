<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        response()->json(MercadoPagoService::Rules());

        $request->validate(
            MercadoPagoService::Rules()
        );


    }

}
