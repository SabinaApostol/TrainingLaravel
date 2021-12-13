<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class IndexController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function show(Request $request)
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Products::whereNotIn('id', $productIds)->get();
        } else {
            $products = Products::all();
        }
        setcookie("csrf", csrf_token());
        if($request->ajax()){
            return response($products);
        }

        return view('index',['products' => $products]);
    }

    public function store(Request $request)
    {
        if (! empty($request->input('id')) && ($request->input('add') ?? NULL)) {
            $id = $request->input('id');
            session()->push('id', $id);
            session()->save();
            return redirect('/');
        }
    }
}
