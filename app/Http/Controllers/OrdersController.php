<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function show()
    {
//        if (! session('admin')) {
//            if(request()->ajax()){
//                return response('no_access');
//            }
//            abort(403);
//        }

        $orders = DB::table('orders')
            ->join('product_order', 'orders.id', '=', 'product_order.order_id')
            ->join('old_products', 'product_order.product_id', '=', 'old_products.id')
            ->select('orders.id', 'orders.date', 'orders.name', 'orders.email', 'old_products.price', DB::raw('SUM(old_products.price) as sum'))
            ->groupBy('orders.id')
            ->get();

        if(request()->ajax()) {
            return response($orders);
        }
        return view('orders', ['orders' => $orders]);
    }
}
