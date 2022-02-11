<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\profile;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function getProfileForSlug($profile){
        $Profile = profile::query()
            ->where('slug', $profile)
            ->orWhere('id',$profile)
            ->first();
        if (is_null($Profile)){
            return response(['message'=>'Profile not found'])->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return response([new ProfileResource($Profile->user)])->setStatusCode(Response::HTTP_OK);
    }

    public function updateAboutProfile(Request $request){

        $validate = $request->validate($this->rules());
        try {
            auth()->user()->profile()->update($validate);
        }catch (QueryException $e){
            return response([$e])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        return response([])->setStatusCode(Response::HTTP_OK);
    }

    private function rules(){
        return [
            'about'=>['required','min:50','max:600','string']
        ];
    }
}
