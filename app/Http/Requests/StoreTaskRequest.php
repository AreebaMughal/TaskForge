<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Task::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['requried', 'string', 'max:255'],
            'description' => ['requried', 'string'],
            'status' => ['required', 'in:completed, in_progress'],
            'due_date' => ['required', 'date'],
            'project_id'=>['required', 'exists:projects,id'],
        ];
    }
}
