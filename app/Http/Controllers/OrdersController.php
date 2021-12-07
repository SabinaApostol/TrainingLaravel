<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function show() {
        if (! session('admin')) {
            abort(403);
        }

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('old_products', 'order_details.product_id', '=', 'old_products.id')
            ->select('orders.id', 'orders.date', 'orders.name', 'orders.email', 'old_products.price', DB::raw('SUM(old_products.price) as sum'))
            ->groupBy('orders.id')
            ->get();

        return view('orders', ['orders' => $orders]);
    }
}
