<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginationHelper;
use App\Models\Workout;
use App\Models\WorkoutGroup;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WorkoutController extends Controller
{
    public function index(Request $request, WorkoutGroup $workoutGroup) {
        $user = JWTAuth::parseToken()->authenticate();

        $query = $workoutGroup->orderBy('order', 'desc');

        $workoutGroups = $query->get();

        return ApiResponse::ok([
            'workoutGroups' => Workout::collection($workoutGroups)
        ]);
    }

    public function show(WorkoutGroup $workoutGroup) {
        $user = JWTAuth::parseToken()->authenticate();

        return ApiResponse::ok(new WorkoutGroupResource($workoutGroup));
    }

    public function store(StoreRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $workoutGroup = (new StoreUseCase(
            $user,
            $request->input('name'),
            $request->input('weekday')
        ))->action();

        return ApiResponse::done('WorkoutGroup created successfully');
    }

    public function update(UpdateRequest $request, WorkoutGroup $workoutGroup)
    {
        $user = JWTAuth::parseToken()->authenticate();

        (new UpdateUseCase(
            $workoutGroup,
            $user,
            $request->input('name'),
            $request->input('weekday')
        ))->action();

        return ApiResponse::done('WorkoutGroup updated successfully');
    }

    public function destroy(WorkoutGroup $workoutGroup)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $workoutGroup->delete();

        return ApiResponse::done('WorkoutGroup deleted successfully');
    }
}
