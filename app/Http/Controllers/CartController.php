<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrder;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Product::whereIn('id', $productIds)->get();
            return view('cart', ['products' => $products]);
        }
        return view('cart', ['products' => new \stdClass()]);
    }

    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            $productIds = session()->get('id');

            if (($key = array_search($request->input('id'), $productIds)) !== false) {
                unset($productIds[$key]);
            }

            session()->forget('id');
            session()->put('id', $productIds);
            return redirect()->route('cart.index');
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        $currentDate = Carbon::now()->toDateTimeString();
        $order = Order::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'date' =>  $currentDate,
            'comments' => $request->input('comments') ?? ''
        ]);

        $products = Product::whereIn('id', session()->get('id'))->get();
        foreach ($products as $product) {
            $order->products()->attach($product->id, ['price' => $product->price]);
        }

        Mail::to(config('mail.to.addr'))->send(new NewOrder($products, $order));
        session()->pull('id');

        return redirect()->route('index.index');
    }
}
