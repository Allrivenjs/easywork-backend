<?php

namespace App\Http\Controllers\Auth\V1;


use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        //login
        if (!$this->authWeb()->attempt($request->only('email','password'))){
            return response(null)->setStatusCode(Response::HTTP_FORBIDDEN);
        }
        $tokenResult  = $this->authWeb()->user()->createToken('authToken');
        $token = $tokenResult->token;
        $this->remember_me($token,$request);
        $token->save();
        return response([
            'user'=>$this->authWeb()->user(),
            'role'=>$this->authWeb()->user()->getRoleNames(),
            'access_token' =>$tokenResult->accessToken,
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
        $validatedData['birthday']=Carbon::make($request->birthday);
        try {
            $user = User::create($validatedData);
        }catch (QueryException $e){
            return response([
                'message'=>$e
            ])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        $tokenResult = $user->createToken('authToken');
        $token=$tokenResult->token;
        return response([
            'access_token' =>$tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
        ])->setStatusCode(Response::HTTP_OK);
    }

    protected function rules(){
        return [
            'name'=>'required|max:255',
            'lastname'=>'required|string',
            'email'=>'required|email|unique:users',
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
