@extends('template')

@section('content')
<div>
    <h1>Cadastrar Categoria</h1>
    <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="code">Código</label>
            <input @readonly($category) type="text" id="code" name="code" value="{{ $category->code ?? null }}">
            @error('code')
                @foreach($errors->get('code') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" value="{{ $category->name ?? null }}">
            @error('name')
                @foreach($errors->get('name') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button>Atualizar</button>
    </form>
    <a href="{{ route('categories.index') }}">Voltar à Lista de Categorias</a>
</div>
@endsection
