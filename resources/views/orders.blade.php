<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, th, td {
            border: 1px solid #000000;
            text-align: center;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
        h1 {
            text-align: center;
            font-size: 50pt;
        }
    </style>
</head>
<body>
    <h1>Orders</h1>
    <table class="center">
        <tr>
            <th>Date</th>
            <th>Customer name</th>
            <th>Customer email</th>
            <th>Total</th>
            <th>Details</th>
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
                <a href="order/{{ $order->id }}">See details</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
