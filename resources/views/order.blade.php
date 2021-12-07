<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        h1 {
            text-align: center;
            font-size: 50pt;
        }
        table, th, td {
            border: 1px solid #000000;
            text-align: center;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
        img {
            height: 30px;
            width: 30px;
        }
        p, ul {
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Order</h1>
    <table class="center">
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
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
