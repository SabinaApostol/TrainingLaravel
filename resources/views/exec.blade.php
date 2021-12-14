<form style="text-align: center;" action="cart" method="post">
    <input id="name" type="text" name="name" placeholder="{{ Lang::get('messages.name') }}" class="width" value="{{ old('name') }}">
    @if ($errors->has('name'))
        <p style="color: red"> {{ $errors->first('name') }}</p>
    @endif
    <br>
    <input id="email" type="text" name="email" placeholder="{{ Lang::get('messages.contact') }}" class="width" value="{{ old('email') }}">
    @if ($errors->has('email'))
        <p style="color: red"> {{ $errors->first('email') }}</p>
    @endif
    <br>
    <textarea id="comments" name="comments" cols="40" rows="10" placeholder="{{ Lang::get('messages.comments') }}" value="{{ old('comment') }}"></textarea>
    <br>
    <div style="text-align: center;">
        <button id="button" name="checkout" value="checkout">{{ Lang::get('messages.checkout') }}</button>
    </div>
</form>
