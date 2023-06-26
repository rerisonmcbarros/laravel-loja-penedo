@extends('template')

@section('content')
    <div class="h-screen flex items-center justify-center bg-neutral-100">
        <div class="-mt-14 px-8 py-8 sm:border sm:rounded-md sm:bg-neutral-50 xl:w-[28%]">
            <div class="text-neutral-900 text-center text-3xl mb-8">
                <img src="{{ Vite::asset('resources/images/penedo-logo.png') }}" alt="" class="w-24 sm:w-32 m-auto">
                <h1 class="font-light">Penedo Social</h1>
            </div>
            
            <form action="{{ route('auth.attempt') }}" method="post" class="flex flex-col">
                @csrf
                <div>    
                    @error('message')
                    @foreach($errors->get('message') as $error)
                        <div class="mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-neutral-900 mb-2">E-mail</label>
                    <div class="relative">
                        <div class="inline-block w-6 absolute top-3 left-2 text-neutral-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>   
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Digite seu e-mail" required class="block w-full py-3 pl-10 pr-4 rounded-md border-0 outline-0 shadow-md ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                    </div> 
                    @error('email')
                    @foreach($errors->get('email') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-neutral-900 mb-2">Senha</label>
                    <div class="relative">
                        <div class="inline-block w-6 absolute top-3 left-2 text-neutral-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Digite sua senha" required class="block w-full py-3 pl-10 pr-4 rounded-md border-0 outline-0 shadow-md ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800 text-gray-900 mb-4">                    
                    </div> 
                    @error('password')
                    @foreach($errors->get('password') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                    @enderror
                </div>
                <a href="#" class="mb-5 text-xs underline decoration-2 decoration-neutral-900">Esqueceu a senha?</a>
                <button class="bg-neutral-900 font-light text-slate-100 py-3 px-4 rounded-md border-0 shadow-sm shadow-neutral-900 hover:shadow-lg hover:shadow-neutral-900 duration-500">Efetuar Login</button>
            </form>  
        </div>
    </div>
@endsection
