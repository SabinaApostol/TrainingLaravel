<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Jobs\SendEmail;
use App\Events\SendEmailEvent;
use App\Events\SendEmailListener;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Mail\NewOrder;

class CartController extends Controller
{
    public function index()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Product::whereIn('id', $productIds)->get();
            if(request()->ajax()) {
                return response($products);
            }
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
            $url = url()->current();
            if (parse_url($url)['path'] === '/cart_destroy') {
                return redirect('/#cart');
            } else {
                return redirect()->route('cart.index');
            }
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
        session()->forget('id');

        $url = url()->current();
        if (parse_url($url)['path'] === '/cartSPA') {
            return redirect('/#cart');
        } else {
            return redirect()->route('cart.index');
        }
    }
//
//    public function store(Request $request)
//    {
//        if (! empty($request->input('id')) && ! empty($request->input('remove')) && $request->input('remove') === 'remove') {
//            $id = $request->input('id');
//            $productIds = session()->get('id');
//            $found = NULL;
//
//            foreach ($productIds as $key => $value) {
//                if ($value === $id) {
//                    $found = $key;
//                }
//            }
//            session()->pull('id');
//            if ($found !== NULL) {
//                unset($productIds[$found]);
//            }
//            session()->put('id', $productIds);
//            session()->save();
//            $url = url()->current();
//            if (parse_url($url)['path'] === '/cartSPA') {
//                return redirect('/#cart');
//            } else {
//                return redirect()->route('cart.index');
//            }
//        } else {
//            $request->validate([
//                'name' => 'required',
//                'email' => 'required|email'
//            ]);
//            $date = date('Y-m-d H:i:s');
//            Order::create([
//                'name' => $request->input('name'),
//                'email' => $request->input('email'),
//                'date' => $date
//            ]);
//            $orderId = Order::where('date', $date)->first();
//
//            $productIds = session()->get('id');
//            $products = Product::whereIn('id', $productIds)->get();
//
//            foreach ($products as $product) {
//                $orderId->products()->attach($product->id);
//            }
//
//            $email = new NewOrder($products,
//                $request->input('name'),
//                $request->input('email'),
//                $request->input('comments') ?? NULL);
//            Mail::to(config('mail.to.addr'))->send($email);
//
//            session()->pull('id');
//            session()->save();
//
//            if(request()->ajax()) {
//                return response($products);
//            }
//            return redirect('index.index');
//        }
//    }
}
