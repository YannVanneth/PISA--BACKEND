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
            'recipes_id' => $this->recipe_id,
            'profile_id' => new UserProfileResource($this->profile),
            'react_count' => $this->react_count,
            'is_verified' => $this->is_verified,
            'replies' => UserCommentModelResource::collection($this->replies),
            'content' => $this->content,
            'is_liked' => $this->reactions->where('user_id', $this->profile_id)->first()->is_liked ?? false,
        ];
    }
}
