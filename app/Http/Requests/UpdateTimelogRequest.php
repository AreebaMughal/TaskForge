<?php

namespace App\Http\Requests;

use App\Models\Timelog;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTimelogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->call('update', Timelog::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'note' => ['required', 'string'],
        ];
    }
}
