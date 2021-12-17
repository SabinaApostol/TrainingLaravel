@extends('layouts.layout')
<h1>{{ __('messages.list_products') }}</h1>
<table>
    <tr>
        <th>{{ __('messages.title') }}</th>
        <th>{{ __('messages.description') }}</th>
        <th>{{ __('messages.price') }}</th>
        <th>{{ __('messages.image') }}</th>
        <th>{{ __('messages.add') }}</th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>
                <img src="{{ asset('/storage/images/' . $product->image) }}"/>
            </td>
            <td>
                <form action="{{ route('index.store') }}" method="post">
                    @csrf
                    <input name="id" value="{{ $product->id  }}" type="hidden">
                    <button type="submit" name="add" value="add">{{ __('messages.add') }}</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<p style="text-align: center;"><a href="cart">{{ __('messages.go_to_cart') }}</a></p>
