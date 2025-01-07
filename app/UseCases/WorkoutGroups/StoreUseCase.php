<?php

namespace App\UseCases\WorkoutGroups;

use App\Models\User;
use App\Models\WorkoutGroup;
use App\UseCases\Core\UseCase;

class StoreUseCase extends UseCase
{
    public function __construct(
        protected User $user,
        protected string $name,
        protected string $weekday
    ) {
    }

    public function action(): WorkoutGroup
    {
        $department = WorkoutGroup::create([
            'name' => $this->name,
            'weekday' => $this->weekday,
            'user_id' => $this->user->id,
        ]);

        return $department;
    }
}
