<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CookingStepsResource extends JsonResource
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
        'steps_number' => $this->steps_number,
        'cooking_instruction_en' => $this->cooking_instruction_en,
        'cooking_instruction_km' => $this->cooking_instruction_km,
    ];
    }
}
