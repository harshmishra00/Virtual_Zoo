<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'slug'                => $this->slug,
            'species'             => $this->whenLoaded('species', fn() => [
                'id'    => $this->species->id,
                'name'  => $this->species->name,
                'class' => $this->species->class,
            ]),
            'enclosure'           => $this->whenLoaded('enclosure', fn() => [
                'id'      => $this->enclosure->id,
                'name'    => $this->enclosure->name,
                'habitat' => $this->enclosure->habitat?->name,
            ]),
            'age'                 => $this->age,
            'gender'              => $this->gender,
            'weight_kg'           => $this->weight_kg,
            'height_cm'           => $this->height_cm,
            'diet'                => $this->diet,
            'conservation_status' => $this->conservation_status,
            'badge_color'         => $this->conservationBadgeColor(),
            'description'         => $this->description,
            'fun_fact'            => $this->fun_fact,
            'arrival_date'        => $this->arrival_date?->format('Y-m-d'),
            'is_featured'         => $this->is_featured,
            'thumbnail_url'       => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'average_rating'      => round($this->averageRating(), 1),
            'created_at'          => $this->created_at->toISOString(),
        ];
    }
}
