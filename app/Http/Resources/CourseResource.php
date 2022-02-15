<?php

namespace App\Http\Resources;

use App\Models\section;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'owner'=>$this->owner,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'image'=>$this->image,
            'sections'=>section::with('videos')->where('course_id','=', $this->id)->get()
        ];
    }
}
