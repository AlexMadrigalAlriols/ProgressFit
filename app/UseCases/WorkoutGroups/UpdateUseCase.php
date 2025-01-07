<?php

namespace App\UseCases\WorkoutGroups;

use App\Models\User;
use App\Models\WorkoutGroup;
use App\UseCases\Core\UseCase;

class UpdateUseCase extends UseCase
{
    public function __construct(
        protected WorkoutGroup $workoutGroup,
        protected User $user,
        protected string $name,
        protected string $weekday
    ) {
    }

    public function action(): WorkoutGroup
    {
        $this->workoutGroup->update([
            'name' => $this->name,
            'weekday' => $this->weekday,
            'user_id' => $this->user->id,
        ]);

        return $this->workoutGroup;
    }
}
