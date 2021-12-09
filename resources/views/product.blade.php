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
    <h1 class="center">{{ Lang::get('messages.add_edit') }}</h1>
    <form style="text-align: center" action="{{ $id ?? NULL }}" method="post" enctype="multipart/form-data">
        @csrf
        <input class="width" type="text" name="title" value="{{ $product->title ?? old('title') }}" placeholder="{{ Lang::get('messages.title') }}">
        @if ($errors->has('title'))
            <p style="color: red"> {{ $errors->first('title') }}</p>
        @endif
        <br>
        <input class="width" type="text" name="description" value="{{ $product->description ?? old('description') }}" placeholder="{{ Lang::get('messages.description') }}">
        @if ($errors->has('description'))
            <p style="color: red"> {{ $errors->first('description') }}</p>
        @endif
        <br>
        <input class="width" type="number" step="0.01" name="price" value="{{ $product->price ?? old('price') }}" placeholder="{{ Lang::get('messages.price') }}">
        @if ($errors->has('price'))
            <p style="color: red"> {{ $errors->first('price') }}</p>
        @endif
        <br>
        <input type="file" name="file">
        @if ($errors->has('file'))
            <p style="color: red"> {{ $errors->first('file') }}</p>
        @endif
        <button>{{ Lang::get('messages.save') }}</button>
    </form>
</body>
</html>
