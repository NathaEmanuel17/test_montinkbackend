<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function updateStatus(Request $request)
    {
        $token = $request->header('X-WEBHOOK-TOKEN');

        if ($token !== config('services.webhook.token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orderId = $request->input('order_id');
        $status = $request->input('status');

        $order = Order::with('items.variation.stock')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($order->status === OrderStatus::CANCELED) {
            return response()->json(['error' => 'Pedido já cancelado. Alteração de status não permitida.'], 403);
        }

        $order->status = OrderStatus::from($status);
        $order->save();

        if ($order->status === OrderStatus::CANCELED) {
            foreach ($order->items as $item) {
                if ($item->variation && $item->variation->stock) {
                    $item->variation->stock->increment('quantity', $item->quantity);
                }
            }
        }

        Log::info("Webhook: Pedido #{$order->id} atualizado para {$status}");

        return response()->json(['message' => 'Status atualizado com sucesso']);
    }
}
