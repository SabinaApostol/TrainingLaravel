<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show()
    {
        $url = url()->current();
        return response()->json($url);
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
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
    }
}
