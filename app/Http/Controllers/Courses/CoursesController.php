<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\course;
use App\Models\section;
use App\Models\video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCourses(){
        return response([course::all()])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $course
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function showCoursesWithSections($course): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response([new CourseResource(
            course::query()->where('slug','Like' ,$course)->first()
        )])->setStatusCode(Response::HTTP_OK);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function storeCourse(Request $request){
        $validate = $request->validate([
                        'name'=>'required',
                        'description'=>'required'
                    ]);
        $validate['owner']=auth()->user()->getAuthIdentifier();
        $validate['slug']=Str::slug($request->name.rand(10, 10000));
        $course=course::create($validate);
        return response([$course])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param course $course
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function storeSection(Request $request,course $course): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
         $validate = $request->validate([
            'name'=>'required'
         ]);
         $validate['course_id']=$course->id;
         $section=section::create($validate);
         return response([$section])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param section $section
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function storeVideo(Request $request,section $section): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $validate = $request->validate([
            'name'=>'required',
            'description'=>'required',
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm | max:102400'
        ]);
        $url=Storage::put('Courses/videos',$request->file('video'));
        $data = array_merge($validate, [
            'url'=>env('APP_URL').'/storage/'.$url,
            'section_id'=>$section->id
        ]);
        $video = video::create($data);
        return response([$video])->setStatusCode(Response::HTTP_OK);
    }
}
