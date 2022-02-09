<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

 //   use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset_password(Request $request){
     $validateData= Validator::make($request->all(), $this->rules());
     if ($validateData->fails()){ return $this->apiReturn([$validateData->errors()], codeEnum::ERROR_PASSWORD_RESET_HAS_BEEN); }
        $status = Password::reset(
            $this->credentials($request),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );


        return $status === Password::PASSWORD_RESET
            ? response(['status'=> __($status)])->setStatusCode(Response::HTTP_OK)
            : response(['email'=> __($status)])->setStatusCode(Response::HTTP_BAD_REQUEST);
    }
    protected function rules(){
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required','confirmed', Rules\Password::defaults()],
        ];
    }
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

}

