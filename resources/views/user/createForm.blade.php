@extends('template')

@section('content')
    <div>
        <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Cadastrar Usuário</h1>
        <form action="{{ route('users.store') }}" method="post" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        @if(session()->has('message'))
        <div>{{ session()->get('message') }}</div>
        @endif
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
            <div>
                <label for="name" class="block text-neutral-900 mb-2">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                @error('name')
                    @foreach($errors->get('name') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="md:flex">
                <div class="md:flex-grow md:me-4">
                    <label for="email" class="block text-neutral-900 mb-2">E-mail</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                    @error('email')
                        @foreach($errors->get('email') as $error)
                            <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                        @endforeach
                    @enderror
                </div> 
                <div class="md:flex-grow md:me-4">
                    <label for="password" class="block text-neutral-900 mb-2">Senha</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                    @error('password')
                        @foreach($errors->get('password') as $error)
                            <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                        @endforeach
                    @enderror
                </div> 
                <div class="md:flex-grow mb-8">
                    <span class="block font-normal text-neutral-900 mb-2">Administrador</span>
                    <div class="mt-4">
                        <label for="true">Sim</label>
                        <input type="radio"  id="true" name="is_admin" value="1" class="me-4">
                        <label for="false">Não</label>
                        <input type="radio"  id="false" name="is_admin" value="0">
                        @error('is_admin')
                            @foreach($errors->get('is_admin') as $error)
                                <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                            @endforeach
                        @enderror
                    </div>     
                </div> 
            </div> 
            <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Cadastrar Usuário</button>
        </form>
    </div>
@endsection
