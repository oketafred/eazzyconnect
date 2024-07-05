<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->created_at->diffForHumans(),
            'message' => $this->message,
            'phoneNumber' => $this->phone_number,
            'status' => $this->status,
            'cost' => $this->cost,
            'messageId' => $this->messageId,
            'failureReason' => $this->failure_reason,
            'groupTitle' => $this->group->title ?? 'Default',
        ];
    }
}
