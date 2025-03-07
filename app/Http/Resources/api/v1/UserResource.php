<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'users_id' => $this->users_id,
            'username' => $this->username,
            'profile' => new UserProfileResource($this->profile),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
