<?php

namespace App\UseCases\Workouts;

use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutGroup;
use App\UseCases\Core\UseCase;

class UpdateUseCase extends UseCase
{
    public function __construct(
        protected Workout $workout,
        protected int $order,
        protected string $name,
        protected string $description,
        protected float $start_weight = 0,
        protected int $num_reps = 0,
        protected array $data = []
    ) {
    }

    public function action(): Workout
    {
        $this->workout->update([
            'order' => $this->order,
            'name' => $this->name,
            'description' => $this->description,
            'start_weight' => $this->start_weight,
            'num_reps' => $this->num_reps,
            'data' => array_merge($this->workout->data, $this->data)
        ]);

        return $this->workout;
    }
}
