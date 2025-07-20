<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');

        $orders = Order::with('items.product', 'items.variation')
            ->where('user_id', $user->id)
            ->when($status, fn($query) => $query->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.index', compact('orders', 'status'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, [OrderStatus::PENDING, OrderStatus::PAID])) {
            return back()->with('error', 'Este pedido não pode ser cancelado.');
        }

        DB::beginTransaction();

        try {
            foreach ($order->items as $item) {
                if ($item->variation_id) {
                    $variation = Variation::find($item->variation_id);

                    if ($variation && $variation->stock) {
                        $variation->stock->increment('quantity', $item->quantity);
                    }
                }
            }

            $order->update(['status' => OrderStatus::CANCELED]);

            DB::commit();
            return back()->with('success', 'Pedido cancelado com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao cancelar o pedido.');
        }
    }
}
