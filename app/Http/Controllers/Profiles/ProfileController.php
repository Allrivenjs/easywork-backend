<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;

use App\Models\profile;
use App\Models\task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        return response(
            task::with([
                'topics',
                'owner',
                'files',
                'status_last',
                'comments_lasted'=>[
                    'owner',
                    'replies'=>[
                        'owner',
                    ],
                ]
            ])->where('own_id', auth()->id())
                ->orderBy('created_at', 'desc')->simplePaginate($request->input('num')?? 5)
        );
    }


    public function getProfileForSlug($profile): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $Profile = profile::query()->with([
            'user'=> [
                'tasks_desc'=>[
                    'topics',
                    'owner',
                    'files',
                    'status_last',
                    'comments_lasted'=>[
                        'owner',
                        'replies'=>[
                            'owner',
                        ],
                    ],
                ],
            ]
        ])
            ->where('slug',$profile)
            ->orWhere('id',$profile)
            ->firstOrFail();
        return response([new ProfileResource($Profile)])->setStatusCode(Response::HTTP_OK);
    }


    public function updateAboutProfile(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $validate = $request->validate($this->rules());
        try {
            Auth()->guard('api')->user()->profile()->update($validate);
        }catch (QueryException $e){
            return response([$e])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    public function updateImageProfile(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
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
        return response(null)->setStatusCode(Response::HTTP_CREATED);

    }


    #[ArrayShape(['about' => "string[]"])] private function rules(): array
    {
        return [
            'about'=>['required','min:50','max:600','string']
        ];
    }
}
