<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'news_content' => $this->news_content,
            'image'        => $this->image,
            'writer'       => $this->writer['username'],
            'created at'   => date_format($this->created_at,'Y/m/d H:i'),
            'total_komentar'=> $this->comments->count(),
            'komentar'     => CommentsResource::collection($this->comments)
        ];
    }
}
