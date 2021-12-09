<?php

namespace App\Http\Controllers;

use App\Models\OldProducts;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function show() {
        if (! session('admin')) {
            abort(403);
        }
        $products = Products::all();
        return view('products', ['products' => $products]);
    }

    public function store(Request $request) {
        request()->validate([
            'id' => 'required',
            'delete' => 'required'
        ]);

        if ($request->input('delete') !== 'delete') {
            abort(404);
        }

        Products::destroy($request->input('id'));
        $order = OrderDetails::where('product_id', $request->input('id'))->first();
        if (! $order) {
            OldProducts::destroy($request->input('id'));
        }
        
        $products = Products::all();
        return view('products', ['products' => $products]);
    }
}
