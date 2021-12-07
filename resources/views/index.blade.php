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
    <h1>List of products</h1>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Add</th>
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
                        <button name="add" value="add">Add</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <p style="text-align: center;"><a href="cart">Go to cart</a></p>
</body>
</html>
