<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCommentModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'users_comment_id' => $this->users_comment_id,
            'recipes_id' => $this->recipes_id,
            'profile_id' => new UserProfileResource($this->profile),
            'username' => $this->profile->username,
            'react_count' => $this->react_count,
            'is_verified' => $this->is_verified,
            'is_liked' => $this->is_liked,
            'replies' => $this->replies,
            'parent_comment_id' => $this->parent_comment_id,
            'comment_content' => $this->comment_content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
