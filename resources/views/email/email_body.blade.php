@component('mail::message')
# {{ __('messages.order') }}
<table>
    <tr>
        <th>{{ __('messages.title') }}</th>
        <th>{{ __('messages.description') }}</th>
        <th>{{ __('messages.price') }}</th>
        <th>{{ __('messages.image') }}</th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td><img style="width: 30px; height: 30px;" src="{{ URL::to('http://127.0.0.1:8000/storage/images/') }}/{{ $product->image }}"/></td>
        </tr>
    @endforeach
</table>
<p>{{ __('messages.name') }}: {{ $order->name }}</p>
<p>{{ __('messages.email') }}: {{ $order->email }}</p>
@if ($order->comments)
    <p>{{ __('messages.comments') }}: {{ $order->comments }}</p>
@endif
@endcomponent
