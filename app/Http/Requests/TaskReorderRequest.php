<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskReorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tasks' => ['required', 'array'],
            'tasks.*.id' => ['required', 'integer', 'exists:tasks,id'],
            'tasks.*.priority' => ['required', 'integer', 'min:1'],
        ];
    }
}
