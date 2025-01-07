<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    public const PAGE_SIZE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workout_group_id',
        'name',
        'order',
        'description',
        'start_weight',
        'num_reps',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function workoutGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorkoutGroup::class);
    }
}
