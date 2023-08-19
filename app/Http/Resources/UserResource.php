<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'image_url' => $this->image_url,
            'token' => $this->createToken('FriendsPointArticle')->accessToken,
            'category' => $this->category->pluck('id')->toArray()
        ];
    }
}
