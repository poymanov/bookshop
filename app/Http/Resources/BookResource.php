<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'year' => $this->year,
            'pages_count' => $this->pages_count,
            'price' => $this->price,
            'image' => $this->image,
            'author' => new AuthorResource($this->author),
        ];
    }
}
