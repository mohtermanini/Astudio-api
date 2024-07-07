<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorCollection;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            //add [attribute] to resource only if it is [present]
            'description' => $this->whenHas('description'),
            //load relationship into the response if it exist in modelObject
            'category' => new CategoryResource($this->whenLoaded('category')),
            'authors' => new AuthorCollection($this->whenLoaded('authors'))
        ];
    }
}
