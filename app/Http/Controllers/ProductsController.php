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
            if(request()->ajax()) {
                return response('no_access');
            }
            abort(403);
        }
        if(request()->ajax()){
            return response(Products::all());
        }
        return view('products', ['products' => Products::all()]);
    }

    public function delete(Request $request)
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
        return redirect('/#products');
    }
}
