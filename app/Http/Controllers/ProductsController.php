<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function show()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function delete(Request $request)
    {
        request()->validate([
            'id' => 'required'
        ]);

        Product::destroy($request->input('id'));
    }
}
