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
    <h1>{{ Lang::get('messages.products') }}</h1>
    <table class="center">
        <tr>
            <th></th>
            <th>{{ Lang::get('messages.title') }}</th>
            <th>{{ Lang::get('messages.description') }}</th>
            <th>{{ Lang::get('messages.price') }}</th>
            <th>{{ Lang::get('messages.edit_product') }}</th>
            <th>{{ Lang::get('messages.delete_product') }}</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>
                <img src="{{ URL::to('/') }}/storage/images/{{ $product->image }}">
            </td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>
                <a href="product/{{ $product->id }}">{{ Lang::get('messages.edit') }}</a>
            </td>
            <td>
                <form action="products" method="post">
                    @method('delete')
                    @csrf
                    <input name="id" value="{{ $product->id }}" type="hidden">
                    <button name="delete" value="delete">{{ Lang::get('messages.delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    <div style="text-align: center;">
        <a href="product">{{ Lang::get('messages.add') }}</a>
        <a href="login">{{ Lang::get('messages.logout') }}</a>
    </div>
</body>
</html>
