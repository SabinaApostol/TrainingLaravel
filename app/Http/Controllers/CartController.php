<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use App\Jobs\SendEmail;
use App\Events\SendEmailEvent;
use App\Events\SendEmailListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Mail\NewOrder;

class CartController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function show(Request $request)
    {
        if (session('id')) {
            $productIds = session()->get('id');
            $products = Products::whereIn('id', $productIds)->get();
            if($request->ajax()){
                return response($products);
            }
            return view('index', ['products' => $products]);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
            return redirect('/#cart');
        }
//        } else {
//            request()->validate([
//                'name' => 'required',
//                'email' => 'required|email'
//            ]);
//
//            $date = date('Y-m-d H:i:s');
//            Orders::create([
//                'name' => $request->input('name'),
//                'email' => $request->input('email'),
//                'date' => $date
//            ]);
//            $orderId = Orders::where('date', $date)->first();
//
//            $productIds = session()->get('id');
//            $products = Products::whereIn('id', $productIds)->get();
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

//            return redirect('/');
//        }
    }
}
