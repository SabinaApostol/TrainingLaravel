@extends('layouts.layout')
@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button name="delete" value="delete">{{ __('messages.logout') }}</button>
            </form>
        @endauth
    </div>
@endif
<h1 class="center">{{ __('messages.add_edit') }}</h1>
<form style="text-align: center" action="{{ $product->id ?? NULL }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($product->id ?? NULL)
        @method('put')
    @endif
    <input class="width" type="text" name="title" value="{{ $product->title ?? old('title') }}" placeholder="{{ __('messages.title') }}">
    @if ($errors->has('title'))
        <p style="color: red"> {{ $errors->first('title') }}</p>
    @endif
    <br>
    <input class="width" type="text" name="description" value="{{ $product->description ?? old('description') }}" placeholder="{{ __('messages.description') }}">
    @if ($errors->has('description'))
        <p style="color: red"> {{ $errors->first('description') }}</p>
    @endif
    <br>
    <input class="width" type="number" step="0.01" name="price" value="{{ $product->price ?? old('price') }}" placeholder="{{ __('messages.price') }}">
    @if ($errors->has('price'))
        <p style="color: red"> {{ $errors->first('price') }}</p>
    @endif
    <br>
    <input type="file" name="file">
    @if ($errors->has('file'))
        <p style="color: red"> {{ $errors->first('file') }}</p>
    @endif
    <button type="submit">{{ __('messages.save') }}</button>
    <br>
    @if($product->id ?? null)
        <td>
            <img src="{{ asset('/storage/images/' . $product->image) }}">
        </td>
    @endif
</form>
