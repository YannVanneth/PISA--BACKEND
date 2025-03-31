<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'users_comment_id' => $this->users_comment_id,
            'recipes_id' => $this->recipe_id,
            'profile' => new UserProfileResource($this->profile),
            'comment_content' => $this->comment_content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
