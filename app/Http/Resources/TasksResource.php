<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
////        dd($this->resource->items()[0]->owner);
//        return array_merge( parent::toArray($request),
//            [
//                'tasks'=>round('get-tasks', $this->own_id),
//            ]
//        );
    }
}
