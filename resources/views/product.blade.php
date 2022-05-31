@extends('layouts.master', ['file'=> 'product']);

@section('product', 'Товар')

@section('content')
    <h1>{{ $product->name }}</h1>
    <h2>{{ $product->code }}</h2>
    <p>Цена: <b>{{ $product->price }} руб.</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{ $product->description }}</p>
    <form action="{{ route('basket-add', $product->id) }}" method="post">
        @csrf
        <button type="submit" {{ $product->isAvailable() ? '' : 'disabled'}} class="btn btn-primary" role="button">В корзину</button>

        {{ $product->category->name }}

    </form>
@endsection
