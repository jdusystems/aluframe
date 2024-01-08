<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOpeningTypeRequest extends FormRequest
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
            'name' => ['required'] ,
            'calculation_type' => ['required'] ,
            'sort_index' => ['required'] ,
            'price' => ['required' , "numeric" , "min:0"] ,
            'image_url' => ['required'],
            'image_name' => ['required'],
        ];
    }
}
