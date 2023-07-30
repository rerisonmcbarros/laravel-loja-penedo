@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Editar Produto</h1>
    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        @method('PUT')
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif

        <div class="md:flex">
            <div class="md:w-1/2 md:me-4">
                <label for="category_id" class="block text-neutral-900 mb-2">Categoria</label>
                <select name="category_id" id="category_id" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                    <option value=""></option>
                   @foreach($categories as $category)
                        <option @selected($product->category->id == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                   @endforeach
                </select>
                @error('category_id')
                    @foreach($errors->get('category_id') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="md:w-1/2"> 
                <label for="code" class="block text-neutral-900 mb-2">Código</label>
                <input type="text" id="code" name="code" value="{{ $product->code ?? null }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('code')
                    @foreach($errors->get('code') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
        </div>
        <div>
            <label for="description" class="block text-neutral-900 mb-2">Descrição</label>
            <input type="text" id="description" name="description" value="{{ $product->description ?? null }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
            @error('description')
                @foreach($errors->get('description') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div class="md:flex">
            <div class="md:w-1/3 md:me-4">
                <label for="purchase_price" class="block text-neutral-900 mb-2">Preço de Compra</label>
                <input type="text" id="purchase_price" name="purchase_price" value="{{ $product->purchase_price ?? null }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('purchase_price')
                    @foreach($errors->get('purchase_price') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="md:w-1/3 md:me-4">
                <label for="sale_price" class="block text-neutral-900 mb-2">Preço de Venda</label>
                <input type="text" id="sale_price" name="sale_price" value="{{ $product->sale_price ?? null }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('sale_price')
                    @foreach($errors->get('sale_price') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="md:w-1/3">
                <label for="storage" class="block text-neutral-900 mb-2">Estoque</label>
                <input type="text" id="storage" name="storage" value="{{ $product->storage ?? null }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('storage')
                    @foreach($errors->get('storage') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
        </div>
        <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Atualizar</button>
    </form>
    <a href="{{ route('products.index') }}" class="bg-blue-500 rounded-md py-2 px-3 text-neutral-100 mt-4 shadow-md shadow-neutral-400">Voltar à Lista de Produtos</a>
</div>
@endsection
