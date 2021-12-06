<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke() {
        if (! session('admin')) {
            abort(403);
        }
        return view('product');
    }

    public function edit(Request $request, $id) {
        if (! session('admin')) {
            abort(403);
        }

        $product = Products::where('id', $id)->first();
        return view('product', ['id' => $id, 'product' => $product]);
    }

    public function update(Request $request, $id) {
        dd($id);
    }
    public function add(Request $request) {
        dd('ADD');
    }
}
