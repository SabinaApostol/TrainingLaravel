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

<h1>{{ __('messages.orders') }}</h1>
<table class="center">
    <tr>
        <th>
            {{ __('messages.date') }}
        </th>
        <th>
            {{ __('messages.customer_name') }}
        </th>
        <th>
            {{ __('messages.customer_email') }}
        </th>
        <th>
            {{ __('messages.total') }}
        </th>
        <th>
            {{ __('messages.details') }}
        </th>
    </tr>
    @foreach ($orders as $order)
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
        <td>
            {{ $order->sum }}
        </td>
        <td>
            <a href="order/{{ $order->id }}">{{ __('messages.see_details') }}</a>
        </td>
    </tr>
    @endforeach
</table>
