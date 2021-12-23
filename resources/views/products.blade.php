@extends('layouts.layout')
@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <form action="{{ route('logout') }}" method="post">
                @method('delete')
                @csrf
                <button name="delete" value="delete">{{ __('messages.logout') }}</button>
            </form>
        @endauth
    </div>
@endif
<h1>{{ __('messages.products') }}</h1>
<table class="center">
    <tr>
        <th></th>
        <th>{{ __('messages.title') }}</th>
        <th>{{ __('messages.description') }}</th>
        <th>{{ __('messages.price') }}</th>
        <th>{{ __('messages.edit_product') }}</th>
        <th>{{ __('messages.delete_product') }}</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>
            <img src="{{ asset('/storage/images/' . $product->image) }}">
        </td>
        <td>{{ $product->title }}</td>
        <td>{{ $product->description }}</td>
        <td>{{ $product->price }}</td>
        <td>
            <a href="product/{{ $product->id }}/edit">{{ __('messages.edit') }}</a>
        </td>
        <td>
            <form action="{{ route('products.destroy', ['id' => $product->id]) }}" method="post">
                @method('delete')
                @csrf
                <button name="delete" value="delete">{{ __('messages.delete') }}</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<br>
<div style="text-align: center;">
    <a href="{{ route('product.create') }}">{{ __('messages.add') }}</a>
</div>
