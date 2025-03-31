<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user_profile_id' => $this->user_profile_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'image_url' => $this->image_url,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'is_verified' => $this->is_verified,
            'otp_code' => $this->otp_code,
            'otp_code_expire_at' => $this->otp_code_expire_at,
            'provider' => $this->provider,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
