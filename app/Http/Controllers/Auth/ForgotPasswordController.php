<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */



    public function forgot_password(Request $request){
            $this->validateEmail($request);

            $status =Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response(['status'=> __($status)])->setStatusCode(Response::HTTP_OK)
                : response(['email'=> __($status)])->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => ['required','email']]);
    }


}

