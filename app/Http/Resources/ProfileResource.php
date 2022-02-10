<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userdata = parent::toArray($request);
        $userdata['created_at']=Carbon::parse($this->created_at)->diffForHumans();
        $userdata['updated_at']=Carbon::parse($this->updated_at)->diffForHumans();
        $data = array_merge($userdata, [
            'profile'=> $this->profile,
//            'images'=> $this->profile?->images
        ]);
        return $data;
    }
}
