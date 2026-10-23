<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'sinopsis'  => $this->sinopsis,
            'year'      => $this->year,
            'poster'    => $this->poster,
            'genre'     => $this->genre_id,
        ];
    }
}