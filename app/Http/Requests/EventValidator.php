<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventValidator extends FormRequest
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
            "date" => 'required|date_format:Y-m-d',
            "booking" =>  "required|integer|in:0,1",
            "zone_id" => "required|integer"
        ];

        if ($this->isMethod('put')) {

            $rules['description'] = 'string|min:3|max:500';
            $rules['date'] = "date_format:Y-m-d";
            $rules['booking'] = "integer|in:0,1";
            $rules['zone_id'] = "integer";

        }

        return $rules;
    }
}
