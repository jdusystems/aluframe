<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWindowColorRequest extends FormRequest
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
            'image_url' => ['required'],
            'image_name' => ['required'],
            'second_image_url' => ['required'],
            'second_image_name' => ['required'],
            'sort_index' => ['required'],
            'vendor_code' => ['required'],
            'price' =>  ['required', 'numeric', 'min:0.01'],
            'profile_color_id' => ['required' , 'integer' ,Rule::exists('profile_colors' ,'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
        ];
    }
}
