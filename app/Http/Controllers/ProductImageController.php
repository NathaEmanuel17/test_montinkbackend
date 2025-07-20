<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductImageController extends Controller
{
    use AuthorizesRequests;

    public function destroy(Request $request, Product $product, ProductImage $image): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $product);

        abort_unless($image->product_id === $product->id, 403, 'A imagem não pertence a este produto.');

        try {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Imagem removida com sucesso.']);
            }

            return back()->with('success', 'Imagem removida com sucesso.');

        } catch (\Exception $e) {
            report($e);

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erro ao remover imagem.'], 500);
            }

            return back()->with('error', 'Erro ao remover imagem.');
        }
    }
}
