<?php

namespace App\Http\Requests\Workouts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order' => 'required|integer',
            'name' => 'required|string|max:40',
            'description' => 'nullable|string|max:255',
            'start_weight' => 'nullable|decimal',
            'num_reps' => 'nullable|integer',
        ];
    }
}
