<?php

namespace App\Resolvers;

use App\Models\PaymentPlatform;
use Exception;


class PaymentPlatformResolver
{
    protected \Illuminate\Database\Eloquent\Collection $paymentPlatforms;

    public function __construct()
    {
        $this->paymentPlatforms = PaymentPlatform::all();
    }

    /**
     * @throws Exception
     */
    public function resolveService($paymentPlatformId)
    {
        $name = strtolower($this->paymentPlatforms->firstWhere('id', $paymentPlatformId)->name);

        $service = config("services.{$name}.class");

        if ($service) {
            return resolve($service);
        }

        throw new Exception('The selected payment platform is not in the configuration');
    }
}
