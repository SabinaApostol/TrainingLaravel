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
           return  response()->json(['error' => true]);
        }
        $products = Products::all();
        if ($products)  {
            return response()->json($products);
        } else {
            return response()->json([]);
        }
    }

    public function delete(Request $request)
    {
        request()->validate([
            'id' => 'required'
        ]);

        Products::destroy($request->input('id'));
        $order = ProductOrder::where('product_id', $request->input('id'))->first();
        if (! $order) {
            OldProducts::destroy($request->input('id'));
        }
    }
}
