<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        if (! session('admin')) {
            if(request()->ajax()){
                return response('no_access');
            }
            abort(403);
        }

        $orders = Order::join('product_order', 'orders.id', '=', 'product_order.order_id')
            ->select('orders.id', 'orders.date', 'orders.name', 'orders.email', 'orders.comments', DB::raw('SUM(product_order.price) as sum'))
            ->groupBy('orders.id')
            ->get();

        if(request()->ajax()) {
            return response($orders);
        }
        return view('orders', ['orders' => $orders]);
    }
}
