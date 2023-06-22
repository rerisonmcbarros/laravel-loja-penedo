@extends('template')

@section('content')
    <div>
        <h1>Cadastrar Usuário</h1>
        <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @if(session()->has('message'))
        <div>{{ session()->get('message') }}</div>
        @endif
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
            <div>
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    @foreach($errors->get('name') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @enderror
            </div> 
            <div>
                <label for="email">E-mail</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    @foreach($errors->get('email') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @enderror
            </div> 
            <div>
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" value="{{ old('password') }}">
                @error('password')
                    @foreach($errors->get('password') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @enderror
            </div> 
            <div>
                <label for="is_admin">Administrador</label>
                <input type="checkbox" id="is_admin" name="is_admin" value="1">
                @error('is_admin')
                    @foreach($errors->get('is_admin') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @enderror
            </div> 
            <button>Cadastrar Usuário</button>
        </form>
    </div>
@endsection
