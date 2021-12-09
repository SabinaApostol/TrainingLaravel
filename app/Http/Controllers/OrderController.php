<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $id;

    public function show($id)
    {
        if (! session('admin')) {
            abort(403);
        }
        $this->id = $id;
        $orderDetails = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('old_products', function ($join) {
                    $join->on( 'order_details.product_id', '=', 'old_products.id')
                        ->where('orders.id', '=', $this->id);
                })
            ->select('orders.id', 'orders.date', 'orders.name', 'orders.email', 'old_products.id as product_id',
                'old_products.title as title', 'old_products.description as description', 'old_products.price as price', 'old_products.image as image')
            ->get();

        return view('order', ['orderDetails' => $orderDetails]);
    }
}
