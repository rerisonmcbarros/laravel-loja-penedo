@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Cadastrar Categoria</h1>
    <form action="{{ route('categories.store') }}" method="post" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div class="md:flex">
            <div class="md:me-4 md:w-1/3">
                <label for="code" class="block text-neutral-900 mb-2">Código</label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('code')
                    @foreach($errors->get('code') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="md:w-2/3">
                <label for="name" class="block text-neutral-900 mb-2">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('name')
                    @foreach($errors->get('name') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
        </div>
        <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400" title="Cadastrar">Cadastrar</button>
    </form>
    <a href="{{ route('categories.index') }}" class="bg-blue-500 rounded-md py-2 px-3 text-neutral-100 mt-4 shadow-md shadow-neutral-400" title="Voltar à lista de Categorias">Voltar à Lista de Categorias</a>
</div>
@endsection
