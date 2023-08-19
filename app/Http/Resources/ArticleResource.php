<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link,
            'tags' => $this->tags,
            'description' => $this->description,
            'image_type' => $this->image_type,
            'media_url' => $this->media_url,
            'like_count' => $this->like_count,
            'share_count' => $this->share_count,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name ?? '',
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->category),
            'created_at' => $this->created_at,
        ];
    }
}
