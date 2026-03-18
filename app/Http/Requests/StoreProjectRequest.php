<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Project::class);
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
            'due_date' => ['required', 'date','after:start_date'],
            'start_date' => ['required', 'date'],
            'client_id' => ['required', 'exists:clients,id',
            function($attribute, $value, $fail) {
                $client = Client::find($value);
                if (!$client || $client->created_by !== auth()->id) {
                    $fail('invalid client id');
                }
            }
            ],
        ];
    }
}
