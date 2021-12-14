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
    <h1>{{ Lang::get('messages.cart') }}</h1>
    <table>
        <tr>
            <th>{{ Lang::get('messages.title') }}</th>
            <th>{{ Lang::get('messages.description') }}</th>
            <th>{{ Lang::get('messages.price') }}</th>
            <th>{{ Lang::get('messages.image') }}</th>
            <th>{{ Lang::get('messages.remove') }}</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td><img src="{{ URL::to('/') }}/storage/images/{{ $product->image }}"/></td>
                <td>
                    <form action="cart" method="post">
                        @csrf
                        <input name="id" value="{{ $product->id  }}" type="hidden">
                        <button name="remove" value="remove">{{ Lang::get('messages.remove') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <form id="form" style="text-align: center;" action="/cart" method="post">
        @csrf
        <input type="text" name="name" placeholder="{{ Lang::get('messages.name') }}" class="width" value="{{ old('name') }}">
        @if ($errors->has('name'))
            <p style="color: red"> {{ $errors->first('name') }}</p>
        @endif
        <br>
        <input type="text" name="email" placeholder="{{ Lang::get('messages.contact') }}" class="width" value="{{ old('email') }}">
        @if ($errors->has('email'))
            <p style="color: red"> {{ $errors->first('email') }}</p>
        @endif
        <br>
        <textarea name="comments" cols="40" rows="10" placeholder="{{ Lang::get('messages.comments') }}" value="{{ old('comment') }}"></textarea>
        <br>
        <div style="text-align: center;">
            <a  href="/">{{ Lang::get('messages.go_to_index') }}</a>
            <button name="checkout" value="checkout">{{ Lang::get('messages.checkout') }}</button>
        </div>
    </form>
</body>
</html>
