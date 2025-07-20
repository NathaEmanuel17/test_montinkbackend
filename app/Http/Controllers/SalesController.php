<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query();

        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $orders->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $orders->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $orders->latest()->paginate(15);

        // Métricas
        $totalSales = Order::where('status', OrderStatus::PAID)->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', OrderStatus::PENDING)->count();
        $canceledOrders = Order::where('status', OrderStatus::CANCELED)->count();

        return view('admin.sales.index', compact('orders', 'totalSales', 'totalOrders', 'pendingOrders', 'canceledOrders'));
    }
}
