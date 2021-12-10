<?php

namespace App\Http\Controllers;

use App\Models\OldProducts;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function show()
    {
        if (! session('admin')) {
            abort(403);
        }

        return view('products', ['products' => Products::all()]);
    }

    public function store(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'delete' => 'required'
        ]);

        if ($request->input('delete') !== 'delete') {
            abort(404);
        }

        Products::destroy($request->input('id'));
        $order = ProductOrder::where('product_id', $request->input('id'))->first();
        if (! $order) {
            OldProducts::destroy($request->input('id'));
        }

        return view('products', ['products' =>  Products::all()]);
    }
}
