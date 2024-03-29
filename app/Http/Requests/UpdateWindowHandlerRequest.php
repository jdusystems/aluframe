<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWindowHandlerRequest extends FormRequest
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
            'name_uz' => ['required'] ,
            'vendor_code' => ['required'] ,
            'price' =>  ['required', 'numeric', 'min:0.01'],
            'profile_type_id' => "required|exists:profile_types,id",
            'profile_color_id' => "required|exists:profile_colors,id"
        ];
    }
}
