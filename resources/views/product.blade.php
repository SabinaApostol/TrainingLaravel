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
        .error {
            color: #FF0000;
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .mywidth {
            width: 300px;
        }
    </style>
</head>
<body>
    <h1 class="center">Add/Edit product</h1>
    <form class="center" action="{{ $id ?? NULL }}" method="post" enctype="multipart/form-data">
        @csrf
        <input class="mywidth" type="text" name="title" value="{{ $product->title ?? old('title') }}" placeholder="Title">
        <br>
        <input class="mywidth" type="text" name="description" value="{{ $product->description ?? old('description') }}" placeholder="description">
        <br>
        <input class="mywidth" type="number" step="0.01" name="price" value="{{ $product->price ?? old('title') }}" placeholder="price">
        <br>
        <input type="file" name="file">
        <button>Save</button>
    </form>
</body>
</html>
