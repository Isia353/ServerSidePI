<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalValidator extends FormRequest
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
            "description" => "required|string|min:3|max:500",
            "sex" => "required|string|in:male,female|lowercase",
            "name" => "required|string|min:3|max:50",
            /*'img.*' => 'required|file|mimetypes:image/*|max:20480',*/
            'img' => 'required|file|mimetypes:image/*|max:20480',
            'conservation_state' => "required|string|in:endangered,vulnerable,leastconcern",
            'zone_id' => "required|integer"
        ];

        if ($this->isMethod('put')) {

            $rules['description'] = 'string|min:3|max:500';
            $rules['img'] = "file|mimetypes:image/*|max:20480";
            $rules['sex'] = "string|in:male,female|lowercase";
            $rules['name'] = "string|min:3|max:50";
            $rules['conservation_state'] = "string|in:Endangered,Vulnerable,leastConcern";
            $rules['zone_id'] = "integer";
        }

        return $rules;
    }
}
