<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneValidator extends FormRequest
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
        $rules = [
            'type' => 'required|string|min:3|max:25',
            'description' => 'required|string|min:3|max:500',
            'user_id' => 'required|integer',
        ];

        if ($this->isMethod('put')) {
            $rules['type'] = 'string|min:3|max:25';
            $rules['user_id'] = "integer";
            $rules['description'] = "string|min:3|max:500";
        }

        return $rules;
    }
}
