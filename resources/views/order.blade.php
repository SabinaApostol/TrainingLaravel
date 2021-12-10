<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Lang::get('messages.doc_title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<h1>{{ Lang::get('messages.order') }}</h1>
    <table class="center">
        <tr>
            <th>
                {{ Lang::get('messages.date') }}
            </th>
            <th>
                {{ Lang::get('messages.name') }}
            </th>
            <th>
                {{ Lang::get('messages.email') }}
            </th>
            <th>
                {{ Lang::get('messages.title') }}
            </th>
            <th>
                {{ Lang::get('messages.description') }}
            </th>
            <th>
                {{ Lang::get('messages.price') }}
            </th>
            <th>
                {{ Lang::get('messages.image') }}
            </th>
        </tr>
        @foreach ($orderDetails as $order)
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
                {{ $order->title }}
            </td>
            <td>
                {{ $order->description }}
            </td>
            <td>
                {{ $order->price }}
            </td>
            <td>
                <img src="{{ URL::to('/') }}/storage/images/{{ $order->image }}">
            </td>
        </tr>
        @endforeach
    </table>
    <br>
</body>
</html>
