@extends('template')

@section('content')
<div>
    <h1>Editar Produto</h1>
    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="category_id">Categoria</label>
            <select name="category_id" id="category_id">
                <option value=""></option>
               @foreach($categories as $category)
                    <option @selected($selected == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
               @endforeach
            </select>
            @error('category_id')
                @foreach($errors->get('category_id') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="code">Código</label>
            <input type="text" id="code" name="code" value="{{ $product->code ?? null }}">
            @error('code')
                @foreach($errors->get('code') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="description">Descrição</label>
            <input type="text" id="description" name="description" value="{{ $product->description ?? null }}">
            @error('description')
                @foreach($errors->get('description') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="purchase_price">Preço de Compra</label>
            <input type="text" id="purchase_price" name="purchase_price" value="{{ $product->purchase_price ?? null }}">
            @error('purchase_price')
                @foreach($errors->get('purchase_price') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="sale_price">Preço de Venda</label>
            <input type="text" id="sale_price" name="sale_price" value="{{ $product->sale_price ?? null }}">
            @error('sale_price')
                @foreach($errors->get('sale_price') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="storage">Estoque</label>
            <input type="text" id="storage" name="storage" value="{{ $product->storage ?? null }}">
            @error('storage')
                @foreach($errors->get('storage') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button>Atualizar</button>
    </form>
    <a href="{{ route('products.index') }}">Voltar à Lista de Produtos</a>
</div>
@endsection