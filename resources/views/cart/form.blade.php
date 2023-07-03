@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Carrinho de Compras</h1>
    <form id="form-remove" method="POST">
        @csrf() 
        @method('DELETE')
    </form>
    <form action="{{ route('cart.addItem') }}" method="POST" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="product_code" class="block text-neutral-900 mb-2">Código do Produto</label>
            <input type="text" id="product_code" name="product_code" value="{{ old('product_code') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('product_code')
                @foreach($errors->get('product_code') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="quantity" class="block text-neutral-900 mb-2">Quantidade</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('quantity')
                @foreach($errors->get('quantity') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Adicionar ao Carrinho</button>
    </form>
    <div class="overflow-auto mb-8 rounded-md shadow-md shadow-neutral-400">
        <table class="w-full border border-collapse bg-gray-100 text-neutral-700">
            <thead class="border bg-gray-200">
                <tr>
                    <th scope="col" class="p-3 text-center">Código</th>
                    <th scope="col" class="p-3 text-center">Descrição</th>
                    <th scope="col" class="p-3 text-center">Quantidade</th>
                    <th scope="col" class="p-3 text-center">Preço</th>
                    <th scope="col" class="p-3 text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->getItems() as $item)
                    <tr class="border border-e hover:bg-gray-50 text-neutral-500">
                        <td class="py-1 text-center">{{ $item->getProduct()->code }}</td>
                        <td class="py-1 text-center">{{ $item->getProduct()->description }}</td>
                        <td class="py-1 text-center">{{ $item->getQuantity() }}</td>
                        <td class="py-1 text-center">{{ $item->getProduct()->sale_price }}</td>
                        <td class="py-1 text-center border w-16">
                            <button type="submit" form="form-remove" formaction="{{ route('cart.removeItem', ['item' => $item->getProduct()->id]) }}" title="remover">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr class="border border-e hover:bg-gray-50 text-neutral-500">
                    <td colspan="3" class="py-1 text-center font-bold border">Total</td>
                    <td class="font-bold text-center">
                        {{ $cart->getTotal() }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="{{ route('sales.create') }}" class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Registrar Venda</a>
</div>
@endsection
