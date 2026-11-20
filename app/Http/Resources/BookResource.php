<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id"           => $this->id,
            "name"         => $this->name,
            "ISBN"         => $this->ISBN,
            "author"       => $this->author,
            "is_available" => ! $this->borrowings()
                ->wherePivot("is_returned", false)
                ->exists(),
            "category"     => $this->whenLoaded("category", fn () => [
                "id"          => $this->category->id,
                "name"        => $this->category->name,
                "description" => $this->category->description,
            ]),
        ];
    }
}
