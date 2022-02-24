<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\profile;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function getProfileForSlug($profile){
        $Profile = profile::query()->with('profile')
            ->where('slug','LIKE', $profile)
            ->orWhere('id',$profile)
            ->first();
        if (is_null($Profile)){
            return response(['message'=>'Profile not found'])->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return response([new ProfileResource($Profile->user)])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateAboutProfile(Request $request){

        $validate = $request->validate($this->rules());

        try {
            Auth()->guard('api')->user()->profile()->update($validate);
        }catch (QueryException $e){
            return response([$e])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    public function updateImageprofile(Request $request){
        $request->validate([
            'image'=>'image|required'
        ]);
        $profile=profile::query()->findOrFail( Auth()->guard('api')->user()->profile->id);
        $url = Storage::put('Images/profiles', $request->file('image'));
        if ($profile->image){
            Storage::delete(str_replace(env('APP_URL').'/storage/', '', $profile->image->url));
            $profile->image()->update([
                'url'=> $url
            ]);
        }else{
            $profile->image()->create([
                'url'=> $url
            ]);
        }
        return response([$profile->image])->setStatusCode(Response::HTTP_OK);
    }


    private function rules(){
        return [
            'about'=>['required','min:50','max:600','string']
        ];
    }
}
