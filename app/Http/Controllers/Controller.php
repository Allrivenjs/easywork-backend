<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use App\Traits\FileTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use AuthTrait;
    use FileTrait;

    /**
     * @param string $ability
     * @return void
     */
    protected static function authorize(string $ability): void
    {
        abort_if(($ability === 'private' && ! (new Controller())->authApi()->check()), Response::HTTP_UNAUTHORIZED, 'Unauthorized', [
            'Content-Type' => 'application/json',
        ]);
    }
}
