<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function __invoke() {
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

        Products::where('id',  $request->input('id'))->delete();
        $products = Products::all();
        return view('products', ['products' => $products]);
    }
}
