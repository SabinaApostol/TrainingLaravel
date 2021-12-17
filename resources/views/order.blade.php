@extends('layouts.layout')
<h1>{{ __('messages.order') }}</h1>
<table class="center">
    <tr>
        <th>
            {{ __('messages.date') }}
        </th>
        <th>
            {{ __('messages.name') }}
        </th>
        <th>
            {{ __('messages.email') }}
        </th>
    </tr>
    <tr>
        <td>
            {{ $order->date }}
        </td>
        <td>
            {{ $order->name }}
        </td>
        <td>
            {{ $order->email }}
        </td>
    </tr>
</table>
<br>
<table class="center">
    <tr>
        <th>
            {{ __('messages.title') }}
        </th>
        <th>
            {{ __('messages.description') }}
        </th>
        <th>
            {{ __('messages.price') }}
        </th>
        <th>
            {{ __('messages.image') }}
        </th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>
            {{ $product->title }}
        </td>
        <td>
            {{ $product->description }}
        </td>
        <td>
            {{ $product->price }}
        </td>
        <td>
            <img src="{{ asset('/storage/images/' . $product->image) }}"/>
        </td>
    </tr>
    @endforeach
</table>
<br>
