<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->notifications_id,
            'title' => $this->title,
            'message' => $this->body,
            'date' => $this->created_at->format('d M Y'),
            'time' => $this->created_at->format('H:i A'),
            'is_read' => $this->is_read,
            'type' => $this->type,
            'user_id' => $this->user_id,
        ];
    }
}
