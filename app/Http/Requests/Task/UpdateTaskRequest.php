<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'title'         => ['sometimes', 'string', 'min:3', 'max:20'],
            'text'          => ['sometimes', 'nullable', 'string', 'max:200'],
            'is_completed'  => ['sometimes', 'boolean'],
            'tags'          => ['sometimes', 'array'],
            'tags.*' => ['integer', Rule::exists('tags', 'id')
                    ->where('user_id', $this->user()->id),
            ],
        ];
    }
}
