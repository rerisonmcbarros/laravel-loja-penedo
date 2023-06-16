@extends('template')

@section('content')
    <div>
        <h1>Login de Usuário</h1>
        <form action="{{ route('auth.attempt') }}" method="POST">
            @csrf
            <div>    
                @error('message')
                @foreach($errors->get('message') as $error)
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
                <input type="text" id="password" name="password">
                @error('password')
                @foreach($errors->get('password') as $error)
                    <div>{{ $error }}</div>
                @endforeach
                @enderror
            </div>
            <button>Efetuar Login</button>
        </form>
    </div>
@endsection