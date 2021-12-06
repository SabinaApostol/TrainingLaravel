<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class IndexController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke ()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Products::whereNotIn('id', $productIds)->get();
        } else {
            $products = Products::all();
        }
        if (! $products->isEmpty()) {
            return view('index', ['products' => $products]);
        }
        else {
            return view('index', ['products' => []]);
        }
    }

    public function store(Request $request) {
        if (! empty($request->input('id')) && ($request->input('add') ?? NULL)) {
            $id = $request->input('id');
            session()->push('id', $id);
            session()->save();
            return redirect('/');
        }
    }
}
