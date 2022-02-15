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
        $data = array_merge($userdata, [
            'role'=>$this->getRoleNames(),
            'profile'=> $this->profile,
//            'images'=> $this->profile?->images
        ]);
        return $data;
    }
}
