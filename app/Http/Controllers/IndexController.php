<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class IndexController extends Controller
{
    public function show()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Products::whereNotIn('id', $productIds)->get();
        } else {
            $products = Products::all();
        }

        return response()->json($products);
    }


    public function store(Request $request)
    {
        $id = $request->id;
        session()->push('id', $id);
        session()->save();
    }
}
