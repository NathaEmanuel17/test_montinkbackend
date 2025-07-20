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
            'zipcode'      => ['required', 'regex:/^\d{5}-?\d{3}$/'],
            'address'      => 'required|string|min:5',
            'number'       => 'required|string|max:10',
            'neighborhood' => 'required|string|min:3',
            'city'         => 'required|string|min:3',
            'state'        => 'required|string|size:2',
            'coupon'       => 'nullable|string|exists:coupons,code',
        ];
    }

}
