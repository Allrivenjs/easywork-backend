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
            'description'=>$this->description,
            'owner'=>$this->owner,
            'created_at'=>Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at'=>Carbon::parse($this->updated_at)->diffForHumans(),
            'sections'=>section::with('videos')->where('course_id','=', $this->id)->get()
        ];
    }
}
