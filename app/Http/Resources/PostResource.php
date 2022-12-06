<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $postID = $this->id;
        return [
            'title' => $this->title,
            'body' => $this->body,
            'categories' => $this->categories()->get(),
            'image' => $this->image(),
            'id' => $this->id
        ];
    }
}
