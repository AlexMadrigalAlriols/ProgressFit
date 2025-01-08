<?php

namespace App\UseCases\Workouts;

use App\Models\Workout;
use App\Models\WorkoutGroup;
use App\UseCases\Core\UseCase;

class StoreUseCase extends UseCase
{
    public function __construct(
        protected WorkoutGroup $workoutGroup,
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
        $workout = Workout::create([
            'order' => $this->order,
            'name' => $this->name,
            'description' => $this->description,
            'start_weight' => $this->start_weight,
            'num_reps' => $this->num_reps,
            'data' => $this->data
        ]);

        return $workout;
    }
}
