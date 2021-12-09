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
    <h1>{{ Lang::get('messages.list_products') }}</h1>
    <table>
        <tr>
            <th>{{ Lang::get('messages.title') }}</th>
            <th>{{ Lang::get('messages.description') }}</th>
            <th>{{ Lang::get('messages.price') }}</th>
            <th>{{ Lang::get('messages.image') }}</th>
            <th>{{ Lang::get('messages.add') }}</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>
                    <img src="{{ URL::to('/') }}/storage/images/{{ $product->image }}"/>
                </td>
                <td>
                    <form action="/" method="post">
                        @csrf
                        <input name="id" value="{{ $product->id  }}" type="hidden">
                        <button name="add" value="add">{{ Lang::get('messages.add') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <p style="text-align: center;"><a href="cart">{{ Lang::get('messages.go_to_cart') }}</a></p>
</body>
</html>
