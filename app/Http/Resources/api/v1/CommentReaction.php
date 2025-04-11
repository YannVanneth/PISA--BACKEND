<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentReaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_profile_id' => $this->user_profile_id,
            'users_comment_id' => $this->users_comment_id,
            'is_liked' => $this->is_liked,
        ];
    }
}
