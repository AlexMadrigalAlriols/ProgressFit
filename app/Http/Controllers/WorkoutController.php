<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Workouts\StoreRequest;
use App\Http\Requests\Workouts\UpdateRequest;
use App\Http\Resources\WorkoutResource;
use App\Models\Workout;
use App\Models\WorkoutGroup;
use App\UseCases\Workouts\StoreUseCase;
use App\UseCases\Workouts\UpdateUseCase;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WorkoutController extends Controller
{
    public function index(Request $request, WorkoutGroup $workoutGroup) {
        $user = JWTAuth::parseToken()->authenticate();

        $query = $workoutGroup->workouts()->orderBy('order', 'desc');
        $workouts = $query->get();

        return ApiResponse::ok([
            'workouts' => WorkoutResource::collection($workouts)
        ]);
    }

    public function show(WorkoutGroup $workoutGroup, Workout $workout) {
        $user = JWTAuth::parseToken()->authenticate();

        return ApiResponse::ok(new WorkoutResource($workout));
    }

    public function store(StoreRequest $request, WorkoutGroup $workoutGroup)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $workout = (new StoreUseCase(
            $user,
            $request->input('name'),
            $request->input('weekday')
        ))->action();

        return ApiResponse::done('WorkoutGroup created successfully');
    }

    public function update(UpdateRequest $request, WorkoutGroup $workoutGroup, Workout $workout)
    {
        $user = JWTAuth::parseToken()->authenticate();

        (new UpdateUseCase(
            $workout,
            $user,
            $request->input('name'),
            $request->input('weekday')
        ))->action();

        return ApiResponse::done('Workout updated successfully');
    }

    public function destroy(WorkoutGroup $workoutGroup, Workout $workout)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $workout->delete();

        return ApiResponse::done('Workout deleted successfully');
    }
}
