<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function show()
    {
        if (! session('admin')) {
            abort(403);
        }

        $orders = DB::table('orders')
            ->join('product_order', 'orders.id', '=', 'product_order.order_id')
            ->join('old_products', 'product_order.product_id', '=', 'old_products.id')
            ->select('orders.id', 'orders.date', 'orders.name', 'orders.email', 'old_products.price', DB::raw('SUM(old_products.price) as sum'))
            ->groupBy('orders.id')
            ->get();

        return view('orders', ['orders' => $orders]);
    }
}
