<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return array_merge(parent::toArray($request), [
            'role' => $this->user->getRoleNames(),
            'images' => $this->image,
            'tasks' => route('profile.get.task', ['user_id'=> $this->id]),
        ]);
    }
}
