<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeFavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'recipes_favorite_id' => $this->recipes_favorite_id,
            'recipes_id' => $this->recipes_id,
            'profile' => new UserProfileResource($this->profile),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
