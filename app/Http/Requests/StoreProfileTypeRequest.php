<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileTypeRequest extends FormRequest
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
            'image_name' => "required" ,
            'image_url' => "required" ,
            'name' => "required" ,
            'vendor_code' => "required" ,
            'uz_name' => "required" ,
            'size_name' => "required" ,
            'calculation_type_id' => "required|exists:calculation_types,id",
            'price' =>  ['required', 'numeric', 'min:0.01'],
            'thickness' =>  ['required', 'numeric', 'min:1'],
            'sort_index' => ['required' , 'integer']
        ];
    }
}
