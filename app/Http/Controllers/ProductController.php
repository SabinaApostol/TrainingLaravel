<?php

namespace App\Http\Controllers;
use App\Models\OldProducts;
use App\Models\ProductOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (! session('admin')) {
            if (request()->ajax()) {
                return response('no_access');
            }
            abort(403);
        }

        return view('product');
    }

    public function edit(Request $request, $id)
    {
        if (! session('admin')) {
            abort(403);
            if($request->ajax()){
                return response('no_access');
            }
        }
        $product = Product::where('id', $id)->first();

        if($request->ajax()){
            return response($product);
        }
        return view('product', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        if (! session('admin')) {
            if($request->ajax()){
                return response('no_access');
            }
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        if ($request->hasFile('file')) {
            request()->validate([
                'file' => 'required|image|mimes:jpg,png,jpeg'
            ]);

            $request->file('file')->store('images', 'public');
            Product::where('id', $id)
                ->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price'),
                    'image' => $request->file('file')->hashName()
                ]);
        } else {
            Product::where('id', $id)
                ->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price')
                ]);
        }
        if ($request->ajax()) {
            return response(Product::all());
        }
        return redirect('products');

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'file' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        $request->file('file')->store('images', 'public');

        Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $request->file('file')->hashName()
        ]);

        if($request->ajax()){
            return response(Product::all());
        }
        return redirect('products');
    }
}
