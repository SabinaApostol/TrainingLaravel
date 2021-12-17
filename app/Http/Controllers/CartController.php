<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrder;

class CartController extends Controller
{
    public function show()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Products::whereIn('id', $productIds)->get();
            return view('cart', ['products' => $products]);
        } else {
            return view('cart', ['products' => []]);
        }
    }

    public function store(Request $request)
    {
        if (! empty($request->input('id')) && ! empty($request->input('remove')) && $request->input('remove') === 'remove') {
            $id = $request->input('id');
            $productIds = session()->get('id');
            $found = NULL;

            foreach ($productIds as $key => $value) {
                if ($value === $id) {
                    $found = $key;
                }
            }
            session()->pull('id');
            if ($found !== NULL) {
                unset($productIds[$found]);
            }

            session()->put('id', $productIds);
            session()->save();

            return redirect('cart');
        } else {
            request()->validate([
                'name' => 'required',
                'email' => 'required|email'
            ]);

            $date = date('Y-m-d H:i:s');
            Orders::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'date' => $date
            ]);
            $orderId = Orders::where('date', $date)->first();

            $productIds = session()->get('id');
            $products = Products::whereIn('id', $productIds)->get();

            foreach ($products as $product) {
                $orderId->products()->attach($product->id);
            }

            Mail::to(config('mail.to.addr'))->send(new NewOrder($products,
                $request->input('name'),
                $request->input('email'),
                $request->input('comments') ?? NULL));

            session()->pull('id');
            session()->save();

            return redirect('/');
        }
    }
}
Schema::create('product_order', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('product_id');
    $table->foreign('product_id')->references('id')->on('old_products')->onDelete('cascade');
    $table->unsignedInteger('order_id');
    $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
    $table->float('price');
    $table->timestamps();
});
