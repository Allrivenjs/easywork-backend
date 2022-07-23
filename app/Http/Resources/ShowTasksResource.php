<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowTasksResource extends JsonResource
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
            'difficulty'=>$this->difficulty,
            'owner'=> [
                'name'=>$this->owner->name,
                'lastname'=>$this->owner->lastname,
                'profile_photo_path'=>$this->owner->profile_photo_path,
                'profile_slug'=>$this->owner->profile->slug
            ],
            'topics'=>$this->topics,
            'files'=>$this->files,
            'comments_lasted'=>$this->comments_lasted,
            'status_last'=>$this->status_last,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
