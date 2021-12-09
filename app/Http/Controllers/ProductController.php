<?php

namespace App\Http\Controllers;
use App\Models\OldProducts;
use App\Models\OrderDetails;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show() {
        if (! session('admin')) {
            abort(403);
        }
        return view('product');
    }

    public function edit($id) {
        if (! session('admin')) {
            abort(403);
        }

        $product = Products::where('id', $id)->first();
        return view('product', ['id' => $id, 'product' => $product]);
    }

    public function update(Request $request, $id) {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        if ($request->hasFile('file')) {
            request()->validate([
                'file' => 'required|image|mimes:jpg,png,jpeg'
            ]);

            $request->file('file')->store('images', 'public');
            Products::where('id', $id)
                ->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price'),
                    'image' => $request->file('file')->hashName()
                ]);
            $order = OrderDetails::where('product_id', $id)->first();
            if (! $order) {
                OldProducts::where('id', $id)
                    ->update([
                        'title' => $request->input('title'),
                        'description' => $request->input('description'),
                        'price' => $request->input('price'),
                        'image' => $request->file('file')->hashName()
                    ]);
            }
        } else {
            Products::where('id', $id)
                ->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price')
                ]);
            $order = OrderDetails::where('product_id', $id)->first();
            if (! $order) {
                OldProducts::where('id', $id)
                    ->update([
                        'title' => $request->input('title'),
                        'description' => $request->input('description'),
                        'price' => $request->input('price')
                    ]);
            }
        }

        return redirect('products');
    }

    public function store(Request $request) {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'file' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        $request->file('file')->store('images', 'public');

        Products::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $request->file('file')->hashName()
        ]);
        OldProducts::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $request->file('file')->hashName()
        ]);

        return redirect('products');
    }
}
