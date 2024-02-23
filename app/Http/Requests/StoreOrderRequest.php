<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'language' => ['required' , 'in:ru,uz'] ,
            'currency_id' => ['required' , 'numeric' , 'min:1' , 'exists:currencies,id'] ,
//            'user_id' => ['required' , 'numeric' , 'min:1' , 'exists:users,id'] ,
            'orders' => 'required|array|min:1' ,
            'phone_number' => ['required' ,'string' , 'max:12'] ,
            'orders.*.profile_type_id' => ['required' ,'integer', Rule::exists('profile_types' , 'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
            'orders.*.window_color_id' => ['required' ,'integer', Rule::exists('window_colors' , 'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
            'orders.*.profile_color_id' => ['required' ,'integer', Rule::exists('profile_colors' , 'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
            'orders.*.opening_type_id' => ['required' ,'integer', 'exists:opening_types,id'] ,
            'orders.*.handler_position_id' => ['required' ,'integer', 'exists:handler_positions,id'] ,
            'orders.*.additional_service_id' => ['integer', Rule::exists('additional_services' , 'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
            'orders.*.assembly_service_id' => ['integer', 'exists:assembly_services,id'] ,
            'orders.*.width' => ['required' , 'numeric' , 'min:1' ],
            'orders.*.height' => ['required' , 'numeric' , 'min:1' ],
            'orders.*.additive_sizes' => ['string' , 'max:1000'],
            'orders.*.quantity_left'  => 'required_without:orders.*.quantity_right|numeric|min:0',
            'orders.*.quantity_right' => 'required_without:orders.*.quantity_left|numeric|min:0',
            'orders.*.number_of_loops' => ['integer' , 'min:0'],
        ];
    }
}
