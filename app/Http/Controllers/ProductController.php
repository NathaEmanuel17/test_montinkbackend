<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $products = Product::where('user_id', Auth::id())->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $this->authorize('create', Product::class);
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        try {
            $product = Auth::user()->products()->create($request->validated());

            foreach ($request->input('variations', []) as $data) {
                $variation = $product->variations()->create([
                    'name' => $data['name'],
                ]);

                $variation->stock()->create([
                    'quantity' => $data['quantity'],
                ]);
            }

            $this->handleProductImagesUpload($request, $product);

            return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar produto: ' . $e->getMessage());
            return back()->with('error', 'Erro ao cadastrar o produto.')->withInput();
        }
    }

    public function show(Product $product): View
    {
        $this->authorize('view', $product);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        try {
            $product->update($request->validated());

            foreach ($request->input('variations', []) as $variationData) {
                if (isset($variationData['id'])) {
                    $variation = $product->variations()->where('id', $variationData['id'])->first();
                    if ($variation) {
                        $variation->update([
                            'name' => $variationData['name'],
                        ]);

                        $variation->stock()->updateOrCreate([], [
                            'quantity' => $variationData['quantity'],
                        ]);
                    }
                } else {
                    $newVariation = $product->variations()->create([
                        'name' => $variationData['name'],
                    ]);

                    $newVariation->stock()->create([
                        'quantity' => $variationData['quantity'],
                    ]);
                }
            }

            $this->handleProductImagesUpload($request, $product);

            return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar o produto.')->withInput();
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        try {
            $this->deleteProductImages($product);
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Produto removido com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir produto: ' . $e->getMessage());
            return back()->with('error', 'Erro ao excluir o produto.');
        }
    }

    /**
     * Trata upload de imagens.
     */
    protected function handleProductImagesUpload(Request $request, Product $product): void
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }
    }

    /**
     * Remove as imagens do banco e do disco.
     */
    protected function deleteProductImages(Product $product): void
    {
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();
        }
    }
}
