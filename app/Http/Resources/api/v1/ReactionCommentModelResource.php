<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReactionCommentModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reaction_comment_id' => $this->reaction_comment_id,
            'comment_id' => new UserCommentModelResource($this->comment),
            'profile_id' => new UserProfileResource($this->profile),
            'reaction' => $this->reaction,
        ];
    }
}
