<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderConfirmationMail;
use App\Models\Coupon;
use App\Models\Variation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Seu carrinho está vazio.');
        }

        DB::beginTransaction();

        try {
            $coupon = null;
            $discount = 0;

            if ($request->filled('coupon')) {
                $coupon = Coupon::where('code', $request->coupon)->first();
                if ($coupon) {
                    $discount = $coupon->discount;
                }
            }

            $subtotal = collect($cart)->sum('subtotal');
            $shippingPrice = (float) $request->shipping_value;
            $total = $subtotal - ($subtotal * ($discount / 100)) + $shippingPrice;

            $order = Auth::user()->orders()->create([
                'status'         => OrderStatus::PENDING,
                'coupon_id'      => $coupon?->id,
                'zip_code'       => $request->zipcode,
                'address'        => $request->address,
                'number'         => $request->number,
                'neighborhood'   => $request->neighborhood,
                'city'           => $request->city,
                'state'          => $request->state,
                'shipping_price' => $shippingPrice,
                'total'          => $total,
            ]);

            foreach ($cart as $item) {
                $variation = !empty($item['variation_id'])
                    ? Variation::find($item['variation_id'])
                    : null;

                $order->items()->create([
                    'product_id'     => $item['product_id'],
                    'variation_id'   => $item['variation_id'] ?? null,
                    'product_name'   => $item['name'],
                    'variation_name' => $variation?->name,
                    'price'          => $item['price'],
                    'quantity'       => $item['quantity'],
                    'subtotal'       => $item['subtotal'],
                ]);

                if ($variation && $variation->stock) {
                    $variation->stock->decrement('quantity', $item['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));

            return redirect()->route('orders.index')->with('success', 'Pedido realizado com sucesso! Verifique seu e-mail.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao finalizar o pedido.', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Erro ao finalizar o pedido.')->withInput();
        }
    }

    public function pay($orderId)
    {
        $order = Auth::user()->orders()->findOrFail($orderId);

        if ($order->status === OrderStatus::PENDING) {
            $order->update(['status' => OrderStatus::PAID]);
            return redirect()->route('orders.index')->with('success', 'Pagamento confirmado com sucesso!');
        }

        return redirect()->route('orders.index')->with('error', 'Não foi possível confirmar o pagamento.');
    }
}
