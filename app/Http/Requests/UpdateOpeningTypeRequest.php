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
            'type_id' => ['required' , 'exists:types,id'] ,
            'sort_index' => ['required' , 'integer'] ,
            'image_url' => ['required'],
            'image_name' => ['required'],
            'handler_positions' => ['required','array'] ,
            'handler_positions.*' => ['exists:handler_positions,id'] ,
        ];
    }
}
