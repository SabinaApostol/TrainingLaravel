<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::join('product_order', 'orders.id', '=', 'product_order.order_id')
            ->select('orders.id', 'orders.date', 'orders.name', 'orders.email', 'orders.comments', DB::raw('SUM(product_order.price) as sum'))
            ->groupBy('orders.id')
            ->get();

        return view('orders', ['orders' => $orders]);
    }
}
