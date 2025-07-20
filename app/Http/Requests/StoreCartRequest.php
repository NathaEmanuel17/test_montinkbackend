<?php

namespace App\Http\Requests;

use App\Models\Variation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'variation_id' => 'nullable|exists:variations,id',
            'quantity'     => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) {
                $variationId = $this->input('variation_id');

                if ($variationId) {
                    $variation = Variation::with('stock')->find($variationId);

                    if ($variation && $variation->stock && $value > $variation->stock->quantity) {
                        $fail('A quantidade solicitada excede o estoque disponível.');
                    }
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'variation_id.exists' => 'A variação selecionada é inválida.',
            'quantity.required'   => 'A quantidade é obrigatória.',
            'quantity.integer'    => 'A quantidade deve ser um número inteiro.',
            'quantity.min'        => 'A quantidade mínima é 1.',
        ];
    }
}
