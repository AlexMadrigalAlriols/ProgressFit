<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutResource extends JsonResource
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
            'order' => $this->order,
            'description' => $this->description,
            'start_weight' => $this->start_weight,
            'num_reps' => $this->num_reps,
            'data' => $this->data,
            'workoutGroup' => [
                'name' => $this->workoutGroup->name,
                'weekday' => $this->workoutGroup->weekday,
            ]
        ];
    }
}
