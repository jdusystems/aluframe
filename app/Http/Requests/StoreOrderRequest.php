<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'orders' => 'required|array|min:1' ,
            'client_id' => ['required' ,'integer', 'exists:clients,id'] ,
            'orders.*.profile_type_id' => ['required' ,'integer', 'exists:profile_types,id'] ,
            'orders.*.window_color_id' => ['required' ,'integer', 'exists:window_colors,id'] ,
            'orders.*.profile_color_id' => ['required' ,'integer', 'exists:profile_colors,id'] ,
            'orders.*.opening_type_id' => ['required' ,'integer', 'exists:opening_types,id'] ,
            'orders.*.handler_type_id' => ['required' ,'integer', 'exists:handler_types,id'] ,
            'orders.*.additional_service_id' => ['integer', 'exists:additional_services,id'] ,
            'orders.*.assembly_service_id' => ['integer', 'exists:assembly_services,id'] ,
            'orders.*.width' => ['required' , 'numeric' ],
            'orders.*.height' => ['required' , 'numeric' ],
            'orders.*.X1' => ['numeric' ],
            'orders.*.X2' => ['numeric' ],
            'orders.*.Y1' => ['numeric' ],
            'orders.*.quantity_right' => ['integer' , 'min:1'],
            'orders.*.quantity_left' => ['integer' , 'min:1'],
            'orders.*.number_of_loops' => ['integer' , 'min:1'],
            'orders.*.comment' => ['string'],
        ];
    }
}
