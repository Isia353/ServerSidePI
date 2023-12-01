<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskValidator extends FormRequest
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
        $rules =[
            'title' => 'required|string|min:3|max:120',
            'level' => 'required|integer|between:0,5',
            'finished' => 'required|integer|in:0,1',
            'description' => 'required|string|min:3|max:500',
        ];

        if ($this->isMethod('put')) {

            $rules['title'] = 'string|min:3|max:120';
            $rules['level'] = "integer|between:0,5";
            $rules['finished'] = "integer|in:0,1";
            $rules['description'] = "string|min:3|max:500";
        }

        return $rules;

    }
}
