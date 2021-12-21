<?php

namespace App\Http\Controllers;

use App\Models\OldProducts;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            return response(Product::all());
        }
        return view('products', ['products' => Product::all()]);
    }

    public function destroy(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'delete' => 'required'
        ]);

        if ($request->input('delete') !== 'delete') {
            abort(404);
        }
        Product::destroy($request->input('id'));

        return redirect('/#products');
    }
}
