<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="w-screen bg-neutral-100 overflow-y-auto">
    <header class="w-screen bg-neutral-900">
        <div class="fixed top-0 w-full h-20 flex items-center justify-between z-10 bg-neutral-900">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="sm:hidden ms-4 p-1 w-14 h-14 text-neutral-100 rounded-sm cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <div class="flex items-center">
                <img src="{{ Vite::asset('resources/images/penedo-logo.png') }}" alt="penedo logo" class="hidden sm:inline-block w-14 sm:w-16 ms-7 me-5 bg-neutral-100 rounded-md">
                <p class="me-16 text-neutral-100 text-2xl">Penedo Social</p>
            </div>
            <div class="hidden sm:block text-neutral-100 mr-10 cursor-pointer">
                <a href="{{ route('auth.logout') }}" class="flex items-center">
                    <p class="mx-2">Sair</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-8 h-8" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>
            </div>   
        </div>
        <div class="fixed top-20 w-3/4  -ms-[75%] sm:ms-0 sm:w-[15.5%] md:w-[25%] lg:w-[20%] h-[calc(100vh-5rem)] sm:pt-10  sm:p-2 bg-neutral-900 overflow-y-auto z-10">
            <ul class="w-full p-">
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200 hover:text-slate-50"> 
                    <a href="{{ route('categories.index') }}" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        <p class="sm:hidden md:block ms-4">Categorias</p>
                    </a>
                </li>
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200">
                    <a href="{{ route('products.index') }}" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                        </svg>
                        <p class="sm:hidden md:block ms-4">Produtos</p>
                    </a>
                </li>
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200">
                    <a href="{{ route('sales.index') }}" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        <p class="sm:hidden md:block ms-4">Vendas</p>
                    </a>
                </li>
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200">
                    <a href="{{ route('purchases.index') }}" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <p class="sm:hidden md:block ms-4">Compras</p>
                    </a>
                </li>
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200">            
                    <a href="{{ route('cart.index') }}" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <p class="sm:hidden md:block ms-4">Registrar Venda</p>
                    </a>
                </li>
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200">
                    <a href="{{ route('purchases.create') }}" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        <p class="sm:hidden md:block ms-4">Registrar Compra</p>
                    </a>
                </li>
                <li class="w-full rounded-md hover:bg-neutral-800 text-slate-200">
                    <a href="#" class="flex items-center w-full py-5 sm:py-4 sm:text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-6 sm:w-8 sm:h-8 ms-4 sm:ms-7 md:ms-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                        </svg>
                        <p class="sm:hidden md:block ms-4">Gráficos</p>
                    </a>
                </li>
            </ul>
            <hr class="my-4 border border-neutral-800 sm:hidden">
            <div class="ms-4 sm:hidden text-neutral-100 mr-10 cursor-pointer">
                <a href="{{ route('auth.logout') }}" class="flex items-center">
                    <p class="mx-2">Sair</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-8 h-8" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>
            </div>  
        </div>  
    </header>
    <main class="sm:float-right sm:w-[84.5%] md:w-[75%] lg:w-[80%] mt-20 h-[calc(100vh-5rem)] sm:p-10 bg-neutral-100 border">
        @yield('content')
    </main>
</body>
</html>
