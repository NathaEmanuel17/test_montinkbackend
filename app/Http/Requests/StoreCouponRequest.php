<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric|min:0|max:100',
            'min_value' => 'required|numeric|min:0',
            'expires_at' => 'required|date|after:today',
            'status' => 'nullable|boolean',
        ];
    }
}
