<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'text'          => $this->text,
            'is_completed'  => $this->is_completed,
            'position'      => $this->position,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'tags'          => $this->tags->map(fn ($tag) => [
                'tag'   => $tag->id,
                'title' => $tag->title,
            ]),
        ];
    }
}
