<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    public function index()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Product::whereNotIn('id', $productIds)->get();
        } else {
            $products = Product::all();
        }

        return view('index', ['products' => $products]);
    }

    public function store(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            if (Product::where('id', $id)->exists()) {
                session()->push('id', $id);
                return redirect()->route('index.index');
            }
        }
        abort(404);
    }
}
