<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Coupon;
use App\Http\Controllers\WebhookController;

Route::post('/webhook/order-status', [WebhookController::class, 'updateStatus']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/coupon/validate/{code}', function ($code) {
    $coupon = Coupon::where('code', $code)
        ->where('status', true)
        ->where(function ($query) {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now());
        })
        ->first();

    if (!$coupon) {
        return response()->json([
            'valid' => false,
            'message' => 'Cupom inválido ou expirado.',
        ]);
    }

    return response()->json([
        'valid'    => true,
        'discount' => $coupon->discount,
        'message'  => 'Cupom aplicado com sucesso!',
    ]);
});
