<?php

namespace App\Traits;

trait AuthTrait
{
    protected function authWeb(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth()->guard('web');
    }

    protected function authApi(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth()->guard('api');
    }
}
