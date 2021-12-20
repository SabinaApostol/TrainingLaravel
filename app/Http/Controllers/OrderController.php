<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show($id)
    {

        $products = Order::join('product_order', 'orders.id', '=', 'product_order.order_id')
            ->join('products', function ($join) use ($id) {
                $join->on( 'product_order.product_id', '=', 'products.id')
                    ->where('orders.id', '=', $id);
                })
            ->select('products.id as product_id', 'products.title as title', 'products.description as description', 'products.price as price', 'products.image as image')
            ->get();
        $order = Order::where('id', $id)->first();
        return view('order', ['products' => $products, 'order' => $order]);
    }
}
