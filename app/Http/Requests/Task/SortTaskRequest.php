<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SortTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tasks'             => ['required', 'array'],
            'tasks.*.id'        => ['required', 'integer', Rule::exists('tasks', 'id')
                ->where('user_id', $this->user()->id)
            ],
            'tasks.*.position'  => ['required', 'integer', 'min:0'],
        ];
    }
}
