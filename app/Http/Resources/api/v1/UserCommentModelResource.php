<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'react_count' => $this->reactCount(),
            'is_verified' => $this->is_verified,
            'replies' => UserCommentModelResource::collection($this->whenLoaded('replies')),
            'contents' => $this->content,
            'is_liked' => $this->reactions()->where('user_id', auth()->id())->exists(),
            'parent_comment_id' => new UserCommentModelResource($this->parentComment),
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
