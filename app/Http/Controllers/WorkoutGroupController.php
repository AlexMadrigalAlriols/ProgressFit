<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginationHelper;
use App\Http\Requests\WorkoutGroups\StoreRequest;
use App\Http\Requests\WorkoutGroups\UpdateRequest;
use App\Http\Resources\WorkoutGroupResource;
use App\Models\WorkoutGroup;
use App\UseCases\WorkoutGroups\StoreUseCase;
use App\UseCases\WorkoutGroups\UpdateUseCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WorkoutGroupController extends Controller
{
    public function index(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        $query = $user->workoutGroups()->orderBy('updated_at', 'desc');

        if(!$request->input('all', false)) {
            $weekday = Carbon::now()->format('l');
            $query->where('weekday', $weekday);
        } else {
            $query->orderByRaw("FIELD(weekday, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')");
        }

        $workoutGroups = $query->get();

        return ApiResponse::ok([
            'workoutGroups' => WorkoutGroupResource::collection($workoutGroups),
            'weekdays' => WorkoutGroup::WEEKDAYS
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
