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
    </style>
</head>
<body>
    <h1>Login</h1>
    <form action="login" method="post">
        @csrf
        <div style="text-align: center">
            <input type="text" name="username" placeholder="Username" value="{{ old('username') }}">
            @if ($errors->has('username'))
                <p style="color: red"> {{ $errors->first('username') }}</p>
            @endif
            <br>
            <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
            @if ($errors->has('password'))
                <p style="color: red"> {{ $errors->first('password') }}</p>
            @endif
            <br>
            <button name="login" value="login">Login</button>
            @if ($errors->has('invalid_credentials'))
                <p style="color: red"> {{ $errors->first('invalid_credentials') }}</p>
            @endif
        </div>
    </form>
</body>
</html>
