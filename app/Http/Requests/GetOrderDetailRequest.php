<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetOrderDetailRequest extends FormRequest
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
            'orders' => 'required|array|min:1' ,
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
            'orders.*.additional_service_id' => ['required' ,'integer', Rule::exists('additional_services' , 'id')->where(function($query){
                $query->whereNull('deleted_at');
            })] ,
            'orders.*.width' => ['required' , 'numeric' , 'min:1' ],
            'orders.*.height' => ['required' , 'numeric' , 'min:1' ],
            'orders.*.X1' => ['numeric' ],
            'orders.*.X2' => ['numeric' ],
            'orders.*.Y1' => ['numeric' ],
            'orders.*.quantity_right' => ['required', 'integer' , 'min:0'],
            'orders.*.quantity_left' => ['required' , 'integer' , 'min:0'],
            'orders.*.number_of_loops' => ['integer' , 'min:1'],
        ];
    }
}