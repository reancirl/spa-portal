<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'id'                => $this->id,
            'title'             => $this->title,
            'slug'              => $this->slug,
            'image'             => url("storage/news/{$this->image}"),
            'summary'           => $this->summary,
            'content'           => $this->content,
            'content_url'       => $this->content_url,
            'dealers'           => $this->dealers,
            'precedence'        => $this->precedence,
            'featured'          => $this->featured,
            'published_at'      => $this->published_at,
            'created_by_user_id'=> $this->created_by_user_id,
            'updated_by_user_id'=> $this->updated_by_user_id,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'dealers'           => $this->dealers
        ];
    }
}
