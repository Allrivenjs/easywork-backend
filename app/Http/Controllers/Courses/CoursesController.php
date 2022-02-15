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
    // Search courses and videos
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
    public function showCoursesWithSections($course)
    {
        return response([new CourseResource(
            course::query()->where('slug','LIKE' ,$course)->first()
        )])->setStatusCode(Response::HTTP_OK);
    }


    public function showVideo($course,$video){
        course::query()->where('slug','LIKE',"%$course%")->firstOrFail();
        $courseD=video::query()->where('slug','LIKE',"%$video%")->with('image')->first();
        return response([$courseD])->setStatusCode(Response::HTTP_OK);
    }



    /// Create, update, delete and forceDelete
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function storeCourse(Request $request){
        $validate = $request->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'required|image'
        ]);

        $validate['owner']=Auth()->guard('web')->user()->getAuthIdentifier();
        $validate['slug']=Str::slug($request->name.rand(10, 10000));
        $course=course::create($validate);
        $url = Storage::put('Images/courses', $request->file('image'));
        $course->image()->create([
            'url'=>$url
        ]);
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
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm | max:102400',
            'image'=>'required|image'
        ]);
        $url=Storage::put('Courses/videos',$request->file('video'));
        $data = array_merge($validate, [
            'url'=>$url,
            'section_id'=>$section->id
        ]);

        $video = video::create($data);

        $url = Storage::put('Images/videos', $request->file('image'));
        $video->image()->create([
            'url'=>$url
        ]);
        return response([$video])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $course
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     * @throws \Throwable
     */
    public function updateCourse(Request $request, $course): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $courseD = course::query()->findOrFail($course);
        $validate = $request->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'image'
        ]);
        if ($request->hasFile('image')){
          if ($courseD->image){
              Storage::delete(str_replace(env('APP_URL').'/storage/', '', $courseD->image->url));
              $url = Storage::put('Images/courses', $request->file('image'));
              $courseD->image()->update([
                  'url'=>$url
              ]);
          }else{
              $url = Storage::put('Images/courses', $request->file('image'));
              $courseD->image()->create([
                  'url'=>$url
              ]);
          }
        }
        $courseD->updateOrFail($validate);
        return response([$courseD])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $section
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     * @throws \Throwable
     */
    public function updateSection(Request $request, $section): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $sectionD = section::query()->findOrFail($section);
        $validate = $request->validate([
            'name'=>'required',
        ]);
        $sectionD->updateOrFail($validate);
        return response([$sectionD])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $video
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     * @throws \Throwable
     */
    public function updateVideo(Request $request, $video): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $videoD = section::query()->findOrFail($video);
        $validate = $request->validate([
            'name'=>'required',
            'image'=>'image'
        ]);
        if ($request->hasFile('image')){
            if ($videoD->image){
                Storage::delete(str_replace(env('APP_URL').'/storage/', '', $videoD->image->url));
                $url = Storage::put('Images/videos', $request->file('image'));
                $video->image()->update([
                    'url'=>$url
                ]);
            }else{
                $url = Storage::put('Images/videos', $request->file('image'));
                $video->image()->create([
                    'url'=>$url
                ]);
            }
        }

        $videoD->updateOrFail($validate);

        return response([$videoD])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $course
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function deleteCourse($course): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        course::query()->findOrFail($course)->delete();
        return response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $section
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function deleteSection($section): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        section::query()->findOrFail($section)->delete();
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $video
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function deleteVideo($video): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        section::query()->findOrFail($video)->delete();
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $course
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function restoreCourse($course): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        course::withTrashed()->findOrFail($course)->restore();
        return response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $section
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function restoreSection($section): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        section::withTrashed()->findOrFail($section)->restore();
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $video
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function restoreVideo($video): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        video::withTrashed()->findOrFail($video)->restore();
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $course
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function forceDeleteCourse($course): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {

            $courseD =course::withTrashed()->findOrFail($course);
            Storage::delete(str_replace(env('APP_URL').'/storage/', '', $courseD->image->url));
            $courseD->forceDelete();

        }catch (\Exception $exception){}

        return response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $section
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function forceDeleteSection($section): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        section::withTrashed()->findOrFail($section)->forceDelete();
        return response([])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $video
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function forceDeleteVideo($video): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $videD=video::withTrashed()->findOrFail($video);
            Storage::delete(str_replace(env('APP_URL').'/storage/', '', $videD->image->url));
            $videD->forceDelete();
        }catch (\Exception $exception){}

        return response([])->setStatusCode(Response::HTTP_OK);
    }

}
