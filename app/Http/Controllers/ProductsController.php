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

    public function destroy($id)
    {
        if ($id) {
            Product::where('id', $id)->delete();
            return view('products', ['products' =>  Product::all()]);
        }
        abort(404);
    }
}
