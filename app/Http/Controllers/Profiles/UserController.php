<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\profile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\Response|Application|ResponseFactory
     */
    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response([new ProfileResource(
            profile::query()->with('user')->whereHas('user', function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->where('id', $this->authApi()->id());
            })->first()
        )])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|Application|ResponseFactory
     */
    public function update(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $validate = $request->validate($this->rules());
        $url = '';
        try {
            if ($request->hasFile('profile_photo_path')) {
                $url = Storage::put('Images/users', $request->file('profile_photo_path'));
                Storage::delete(str_replace(env('APP_URL').'/storage/', '', $this->authApi()->user()->profile_photo_path));
                $validate['profile_photo_path'] = $url;
            }
            $this->authApi()->user()->update($validate);
        } catch (QueryException $e) {
            Storage::delete($url);
            return response($e)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        return response(null)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['name' => 'string', 'lastname' => 'string', 'phone' => 'string', 'birthday' => 'string', 'profile_photo_path' => 'string'])]
     private function rules(): array
     {
         return [
             'name' => 'required',
             'lastname' => 'required',
             'phone' => 'string|required',
             'birthday' => 'required|date',
             'profile_photo_path' => 'image',
         ];
     }
}
