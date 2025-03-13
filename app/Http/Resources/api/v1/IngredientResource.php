<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'ingredients_id' => $this->ingredients_id,
            'recipes_id' => $this->recipes_id,
            'ingredients_name_en' => $this->ingredients_name_en,
            'ingredients_name_km' => $this->ingredients_name_km,
            'ingredients_quantity' => $this->ingredients_quantity,
            'ingredients_unit' => $this->ingredients_unit,
            'ingredients_imageURL' => $this->ingredients_imageURL,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
