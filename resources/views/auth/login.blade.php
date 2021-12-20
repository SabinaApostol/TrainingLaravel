@extends('layouts.layout')
@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif
<h1 class="center">{{ __('messages.login') }}</h1>
<form style="text-align: center" method="POST" action="{{ route('login') }}">
    @csrf
    <input id="email" class="block mt-1 w-full" type="text" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email') }}"/>
    <br>
    <input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="{{ __('messages.password') }}" />
    <br>
    <button>{{ __('Log in') }}</button>
</form>
