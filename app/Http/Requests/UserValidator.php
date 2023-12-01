<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserValidator extends FormRequest
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
        $userId = $this->route('user');

        $rules = [
            "name" => "required|string|min:3|max:20",
            "phone" =>  'required|integer|min:100000000|max:10000000000',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[0-9].*[0-9])[a-zA-Z0-9]+$/'
            ], // At least 2 numbers
            "type" => "required|integer"
        ];
        if ($this->isMethod('put')) {

            $rules['name'] = 'string|min:3|max:20';
            $rules['phone'] = "integer|min:9|max:15";
            $rules['email'] = "email|unique:users,email,' . $userId";
            $rules['password'] = ['string','min:8',Rule::regex('/^(?=.*[0-9].*[0-9])[a-zA-Z0-9]+$/')];
        }

        return $rules;
    }
}
