<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'recipes_id' => $this->recipes_id,
            'recipes_title_km' => $this->recipes_title_km,
            'recipes_title_en' => $this->recipes_title_en,
            'recipes_description_km' => $this->recipes_description_km,
            'recipes_description_en' => $this->recipes_description_en,
            'recipes_imageURL' => $this->recipes_imageURL,
            'recipes_videoURL' => $this->recipes_videoURL,
            'recipes_created_by' => $this->recipes_created_by,
            'recipes_view_counts' => $this->recipes_view_counts,
            'recipes_duration' => $this->recipes_duration,
            'recipe_categories_id' => $this->recipe_categories_id,
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
        ];
    }
}
