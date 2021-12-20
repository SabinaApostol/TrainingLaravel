@extends('layouts.layout')
@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/products') }}">{{ __('messages.products') }}</a>
        @else
            <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
        @endauth
    </div>
@endif
<h1>{{ __('messages.cart') }}</h1>
<table>
    <tr>
        <th>{{ __('messages.title') }}</th>
        <th>{{ __('messages.description') }}</th>
        <th>{{ __('messages.price') }}</th>
        <th>{{ __('messages.image') }}</th>
        <th>{{ __('messages.remove') }}</th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td><img src="{{ asset('/storage/images/' . $product->image) }}"/></td>
            <td>
                <form action="{{ route('cart.destroy') }}" method="post">
                    @csrf
                    @method('delete')
                    <input name="id" value="{{ $product->id  }}" type="hidden">
                    <button type="submit" name="remove" value="remove">{{__('messages.remove') }}</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<br>
<form style="text-align: center;" action="{{ route('cart.store') }}" method="post">
    @csrf
    <input type="text" name="name" placeholder="{{ __('messages.name') }}" class="width" value="{{ old('name') }}">
    @if ($errors->has('name'))
        <p style="color: red"> {{ $errors->first('name') }}</p>
    @endif
    <br>
    <input type="text" name="email" placeholder="{{ __('messages.contact') }}" class="width" value="{{ old('email') }}">
    @if ($errors->has('email'))
        <p style="color: red"> {{ $errors->first('email') }}</p>
    @endif
    <br>
    <textarea name="comments" cols="40" rows="10" placeholder="{{ __('messages.comments') }}" value="{{ old('comment') }}"></textarea>
    <br>
    <div style="text-align: center;">
        <a  href="/">{{ __('messages.go_to_index') }}</a>
        <button type="submit" name="checkout" value="checkout">{{ __('messages.checkout') }}</button>
    </div>
</form>
