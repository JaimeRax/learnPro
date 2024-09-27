<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        return [
            'first_name'=> 'required',
            'second_name'=> 'required',
            'first_lastname'=> 'required',
            'second_lastname'=> 'required',
            'personal_code'=> 'required',
            'gender'=> 'required',
            'birthdate'=> 'required',
            'town_ethnicity'=> 'required',
        ];
    }
}
