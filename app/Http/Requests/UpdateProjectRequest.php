<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after:start_date'],
            'client_id' => [
                'required',
                'exists:clients,id',
                function ($attribute, $value, $fail) {
                    $client = Client::find($value);
                    if (!$client || $client->created_by !== auth()->id) {
                        $fail('invalid client id');
                    }
                }
            ],
            'members' => ['nullable', 'array'],
            'members.*' => ['exists:users,id'],
        ];
    }
}
