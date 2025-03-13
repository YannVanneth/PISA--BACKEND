<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialLoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'social_login_id' => $this->social_login_id,
            'social_login_provider' => $this->social_login_provider,
            'social_login_provider_id' => $this->social_login_provider_id,
            'profile' => new UserProfileResource($this->profile),
            'access_token' => $this->access_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
