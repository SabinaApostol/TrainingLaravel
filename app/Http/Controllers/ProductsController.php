<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products', ['products' => Product::all()]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        Product::where('id', $request->input('id'))->delete();
        return view('products', ['products' =>  Product::all()]);
    }
}
