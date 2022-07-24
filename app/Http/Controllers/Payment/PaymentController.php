<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resolvers\PaymentPlatformResolver;

class PaymentController extends Controller
{


    public function __construct(protected PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

    }

    public function pay(Request $request)
    {
        $rules = [
            'value' => ['required', 'numeric', 'min:5'],
            'currency' => ['required', 'exists:currencies,iso'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $request->validate($rules);

        try {
            $paymentPlatform = $this->paymentPlatformResolver
                ->resolveService($request->payment_platform);
        } catch (\Exception $e) {

        }

        session()->put('paymentPlatformId', $request->payment_platform);

        if ($request->user()->hasActiveSubscription()) {
            $request->value = round($request->value * 0.9, 2);
        }

        return $paymentPlatform->handlePayment($request);
    }

    public function approval()
    {
        if (session()->has('paymentPlatformId')) {
            $paymentPlatform = $this->paymentPlatformResolver
                ->resolveService(session()->get('paymentPlatformId'));

            return $paymentPlatform->handleApproval();
        }

        return redirect()
            ->route('home')
            ->withErrors('We cannot retrieve your payment platform. Try again, plase.');
    }

    public function cancelled()
    {
        return redirect()
            ->route('home')
            ->withErrors('You cancelled the payment');
    }
}
