<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeRatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'recipes_rating_id' => $this->recipes_rating_id,
            'recipes_id' => $this->recipes_id,
            'profile' => new UserProfileResource($this->profile),
            'recipe' => new RecipesResource($this->whenLoaded('recipes')),
            'rating_value' => $this->rating_value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
