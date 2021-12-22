<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


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

        return response()->json($products);
    }


    public function store(Request $request)
    {
        $id = $request->id;
        session()->push('id', $id);
    }
}
