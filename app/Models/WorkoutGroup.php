<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutGroup extends Model
{
    use HasFactory;

    public const PAGE_SIZE = 7;

    public const WEEKDAYS = [
        'monday' => 'monday',
        'tuesday' => 'tuesday',
        'wednesday' => 'wednesday',
        'thursday' => 'thursday',
        'friday' => 'friday',
        'saturday' => 'saturday',
        'sunday' => 'sunday',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'weekday',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workouts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Workout::class);
    }
}
