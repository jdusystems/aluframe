<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfileColorRequest extends FormRequest
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
            'vendor_code' => ['required'],
            'uz_name' => ['required'],
            'image_name' => ['required'],
            'image_url' => ['required'],
            'sort_index' => ['required' , 'integer'],
            'color_from' => ['required'],
            'color_to' => ['required'] ,
            'profile_type_id' => ['required' , 'integer' ,Rule::exists('profile_types' ,'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
        ];
    }
}
