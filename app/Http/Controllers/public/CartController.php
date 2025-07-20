<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function store(StoreCartRequest $request, Product $product)
    {
        $validated = $request->validated();
        $variationId = $validated['variation_id'] ?? null;
        $quantity = $validated['quantity'];

        $variationName = $variationId
            ? $product->variations->where('id', $variationId)->first()?->name
            : null;

        $item = [
            'product_id'   => $product->id,
            'variation_id' => $variationId,
            'name'         => $product->name,
            'variation'    => $variationName,
            'price'        => $product->price,
            'quantity'     => $quantity,
            'subtotal'     => $product->price * $quantity,
        ];

        $cart = session()->get('cart', []);

        $key = $product->id . ($variationId ? "-$variationId" : '');

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
            $cart[$key]['subtotal'] = $cart[$key]['price'] * $cart[$key]['quantity'];
        } else {
            $cart[$key] = $item;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }
}
