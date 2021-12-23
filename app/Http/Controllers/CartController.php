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
use Illuminate\Support\Facades\Validator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Mail\NewOrder;

class CartController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function show()
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Product::whereIn('id', $productIds)->get();
            return response()->json($products);
        } else {
            return response()->json(new \stdClass());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

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
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $productIds = session()->get('id');

        if (($key = array_search($id, $productIds)) !== false) {
            unset($productIds[$key]);
        }

        session()->forget('id');
        session()->put('id', $productIds);

    }
}
