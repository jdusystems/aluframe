<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileColorRequest extends FormRequest
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
            'name' => ['required'],
            'uz_name' => ['required'],
            'sort_index' => ['required' , 'integer'],
            'color_from' => ['required'],
            'color_to' => ['required'],
            'image_name' => ['required'],
            'image_url' => ['required'],
            'profile_type_id' => ['required' , 'integer' , 'exists:profile_types,id'] ,
        ];
    }
}
