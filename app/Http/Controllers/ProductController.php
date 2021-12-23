<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'file' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $request->file('file')->store('images', 'public');

        Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $request->file('file')->hashName()
        ]);
    }
}
