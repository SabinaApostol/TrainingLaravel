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
            margin-left: auto;
            margin-right: auto;
        }
        .width {
            width: 300px;
        }
        img {
            height: 30px;
            width: 30px;
        }
    </style>
</head>
<body>
    <h1>Cart</h1>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Remove</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td><img src="{{ URL::to('/') }}/images/{{ $product->image }}"/></td>
                <td>
                    <form action="cart" method="post">
                        @csrf
                        <input name="id" value="{{ $product->id  }}" type="hidden">
                        <button name="remove" value="remove">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <form style="text-align: center;" action="/cart" method="post">
        @csrf
        <input type="text" name="name" placeholder="Name" class="width" value="{{ old('name') }}">
        @if ($errors->has('name'))
            <p style="color: red"> {{ $errors->first('name') }}</p>
        @endif
        <br>
        <input type="text" name="email" placeholder="Contact details" class="width" value="{{ old('email') }}">
        @if ($errors->has('email'))
            <p style="color: red"> {{ $errors->first('email') }}</p>
        @endif
        <br>
        <textarea name="comments" cols="40" rows="10" placeholder="Comments" value="{{ old('comment') }}"></textarea>
        <br>
        <div style="text-align: center;">
            <a  href="/">Go to index</a>
            <button name="checkout" value="checkout">Checkout</button>
        </div>
    </form>
</body>
</html>
