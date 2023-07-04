@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Registrar Compra</h1>
    @if(session()->has('message'))
        <div>{{ session()->get('message') }}</div>
    @endif
    <form id="form-remove" method="POST">
        @csrf() 
        @method('DELETE')
    </form>
    <form action="{{ route('purchases.addItem') }}" method="POST" class="flex flex-col sm:block border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        <div class="sm:flex">
            <div class="sm:w-1/4 sm:me-4 sm:min-w-min">
                <label for="code" class="block text-neutral-900 mb-2 whitespace-nowrap">Código do Produto</label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('code')
                    @foreach($errors->get('code') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="sm:w-full">
                <label for="description" class="block text-neutral-900 mb-2">Descrição</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('description')
                    @foreach($errors->get('description') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
        </div>
        <div class="sm:flex">
            <div class="sm:w-1/5 sm:me-4">
                <label for="price" class="block text-neutral-900 mb-2">Preço</label>
                <input type="text" id="price" name="price" value="{{ old('price') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('price')
                    @foreach($errors->get('price') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="sm:w-1/6 sm:me-4">
                <label for="quantity" class="block text-neutral-900 mb-2">Quantidade</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4"> 
                @error('quantity')
                    @foreach($errors->get('quantity') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="sm:w-max sm:pt-8">
                <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Adicionar Item</button>    
            </div>
        </div>  
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
                @foreach($purchase->getItems() as $index => $item)        
                    <tr class="border border-e hover:bg-gray-50 text-neutral-500">
                        <td class="py-1 text-center">{{ $item->getCode() }}</td>
                        <td class="py-1 text-center">{{ $item->getDescription() }}</td>
                        <td class="py-1 text-center">{{ $item->getQuantity() }}</td>
                        <td class="py-1 text-center">{{ $item->getPrice() }}</td>
                        <td class="py-1 text-center">
                            <button type="submit" form="form-remove" formaction="{{ route('purchases.removeItem', ['item' => $index]) }}" title="remover">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr class="border text-neutral-500">
                    <th class="py-3 text-center" colspan="3" scope="row" >Total</th>
                    <td class="py-3 text-center font-bold">
                        {{ $purchase->getTotal() }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <form id="form-store" method="POST" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        <div class="sm:flex">
            <div class="sm:w-2/3 sm:me-4">
                <label for="supplier" class="block text-neutral-900 mb-2">Fornecedor</label>
                <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('supplier')
                    @foreach($errors->get('supplier') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="sm:w-1/3 sm:me-4">
                <label for="invoice" class="block text-neutral-900 mb-2">Nota Fiscal</label>
                <input type="text" id="invoice" name="invoice" value="{{ old('invoice') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('invoice')
                    @foreach($errors->get('invoice') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
        </div>
        <div class="sm:flex">
            <div class="sm:w-2/3 sm:me-4">
                <label for="purchase_description" class="block text-neutral-900 mb-2">Descrição</label>
                <input type="text" id="purchase_description" name="purchase_description" value="{{ old('purchase_description') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('purchase_description')
                    @foreach($errors->get('purchase_description') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="sm:mt-8">
                <button form="form-store" formaction="{{ route('purchases.store') }}" class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Registrar Compra</button>
            </div>
        </div>      
    </form>   
</div>
@endsection
