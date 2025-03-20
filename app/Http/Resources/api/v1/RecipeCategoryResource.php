<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'recipe_categories_km' => $this->recipe_categories_km,
            'recipe_categories_en' => $this->recipe_categories_en,
            'image_url'=> $this->imageURL,
        ];
    }
}
