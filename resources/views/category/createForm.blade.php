@extends('template')

@section('content')
<div>
    <h1>Cadastrar Categoria</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="code">Código</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}">
            @error('code')
                @foreach($errors->get('code') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                @foreach($errors->get('name') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button>Cadastrar</button>
    </form>
    <a href="{{ route('categories.index') }}">Voltar à Lista de Categorias</a>
</div>
@endsection
