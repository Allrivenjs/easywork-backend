<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(){
        return response([new ProfileResource(auth()->user())])->setStatusCode(Response::HTTP_OK);
    }

    public function update(Request $request){
        $validate=$request->validate($this->rules());
        $url ='';
        try {
            if ($request->hasFile('profile_photo_path')){
                $url = Storage::put('Images/users', $request->file('profile_photo_path'));
            }
            $validate['profile_photo_path']=env('APP_URL').'/storage/'.$url;
            auth()->user()->update($validate);
        }catch (QueryException $e){
            Storage::delete($url);
            return response([$e])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    private function rules(){
        return [
            'name'=>'required',
            'lastname'=>'required',
            'phone'=>'string|required',
            'birthday'=>'required|date',
            'profile_photo_path'=>'image',
        ];
    }
}