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
        protected User $user,
        protected string $name,
        protected string $weekday
    ) {
    }

    public function action(): Workout
    {
        $this->workout->update([
            'name' => $this->name,
            'weekday' => $this->weekday,
            'user_id' => $this->user->id,
        ]);

        return $this->workout;
    }
}
