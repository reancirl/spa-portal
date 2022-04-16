<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use App\Services\AssetsService;

class AssetsResource extends JsonResource
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
            'category_id' => $this->category_id,
            'folder_id' => $this->folder_id,
            'name' => $this->name,
            'file' => $this->file,
            'preview_url' =>  (new AssetsService())->getPreviewImageUrl($this),
            'download_url' => url("/assets/{$this->id}/file/{$this->file}/download"),
            'description' => $this->description,
            'extension' => $this->extension,
            'size_display' => $this->size_display,
            'mime_type' => $this->mime_type, 
            'height' => $this->height,
            'width' => $this->width,
            'published_at' => $this->published_at,
            'expired_at' => $this->expired_at,
            'status' => $this->status,
            'precedence' => $this->precedence,
            'dealers' => $this->dealers, 
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
