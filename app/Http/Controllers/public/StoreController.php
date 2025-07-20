<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('images')->whereHas('images');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        return view('public.store.index', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load(['images', 'variations.stock']);
        return view('public.store.show', compact('product'));
    }
}
