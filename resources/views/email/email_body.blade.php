@component('mail::message')
# {{ Lang::get('messages.order') }}
<table>
    <tr>
        <th>{{ Lang::get('messages.title') }}</th>
        <th>{{ Lang::get('messages.description') }}</th>
        <th>{{ Lang::get('messages.price') }}</th>
        <th>{{ Lang::get('messages.image') }}</th>
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
<p>{{ Lang::get('messages.name') }}: {{ $name }}</p>
<p>{{ Lang::get('messages.email') }}: {{ $email }}</p>
@if ($comments)
    <p>{{ Lang::get('messages.comments') }}: {{ $comments }}</p>
@endif
@endcomponent
