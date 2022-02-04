<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //login
        if (!auth()->attempt($request->only('email','password'))){
            return response()->json()->setStatusCode(Response::HTTP_FORBIDDEN);
        }
        $tokenResult  = auth()->user()->createToken('authToken');
        $token = $tokenResult->token;
        $this->remember_me($token,$request);
        $token->save();
        return response([
            'access_token'=> $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
        ])->setStatusCode(Response::HTTP_OK);
    }
    protected function remember_me($token, Request $request){
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate($this->rules());
        $validatedData['password']=Hash::make($request->password);
        $user = User::create($validatedData)->assignRole('Student');
        $tokenResult = $user->createToken('authToken');
        $token=$tokenResult->token;
        return response([
            'access_token' =>  $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ])->setStatusCode(Response::HTTP_OK);
    }

    protected function rules(){
        return [
            'name'=>'required|max:255',
            'lastname'=>'required|string',
            'email'=>'required|confirmed|email|unique:users',
            'phone' => 'required',
            'birthday' =>'required',
            'password'=> ['required', Rules\Password::defaults()],
        ];
    }
    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
