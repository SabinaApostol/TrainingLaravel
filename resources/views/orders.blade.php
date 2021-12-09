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
    <h1>{{ Lang::get('messages.orders') }}</h1>
    <table class="center">
        <tr>
            <th>{{ Lang::get('messages.date') }}</th>
            <th>{{ Lang::get('messages.customer_name') }}</th>
            <th>{{ Lang::get('messages.customer_email') }}</th>
            <th>{{ Lang::get('messages.total') }}</th>
            <th>{{ Lang::get('messages.details') }}</th>
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
                <a href="order/{{ $order->id }}">{{ Lang::get('messages.see_details') }}</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
