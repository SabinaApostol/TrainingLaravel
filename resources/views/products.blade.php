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
        img {
            height: 30px;
            width: 30px;
        }
    </style>
</head>
<body>
    <h1>Products</h1>
    <table class="center">
        <tr>
            <th></th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Edit product</th>
            <th>Delete product</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>
                <img src="{{ URL::to('/') }}/images/{{ $product->image }}">
            </td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>
                <a href="product/{{ $product->id }}">Edit</a>
            </td>
            <td>
                <form action="products" method="post">
                    @csrf
                    <input name="id" value="{{ $product->id }}" type="hidden">
                    <button name="delete" value="delete">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    <div style="text-align: center;">
        <a href="product">Add</a>
        <a href="login">Logout</a>
    </div>
</body>
</html>
