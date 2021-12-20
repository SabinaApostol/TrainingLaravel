<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class IndexController extends Controller
{
    public function index(Request $request)
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Product::whereNotIn('id', $productIds)->get();
        } else {
            $products = Product::all();
        }
        setcookie("csrf", csrf_token());
        if($request->ajax()){
            return response($products);
        }
        return view('index',['products' => $products]);
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
