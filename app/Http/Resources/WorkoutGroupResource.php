<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutGroupResource extends JsonResource
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
            'name' => $this->name,
            'weekday' => $this->weekday,
            'user' => UserResource::make($this->user) ?? [],
            'workouts' => WorkoutResource::collection($this->workouts) ?? [],
        ];
    }
}
