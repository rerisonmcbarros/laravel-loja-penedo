@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Registrar Compra</h1>
    <form action="{{ route('purchases.store') }}" method="post" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        <div class="md:flex">
            <div class="md:w-2/3 md:me-4">
                <label for="supplier" class="block text-neutral-900 mb-2">Fornecedor</label>
                <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('supplier')
                    @foreach($errors->get('supplier') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
            <div class="md:w-1/3 md:me-4">
                <label for="invoice" class="block text-neutral-900 mb-2">Nota Fiscal</label>
                <input type="text" id="invoice" name="invoice" value="{{ old('invoice') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                @error('invoice')
                    @foreach($errors->get('invoice') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
            </div>
        </div>
        <div>
            <label for="purchase_description" class="block text-neutral-900 mb-2">Descrição</label>
            <input type="text" id="purchase_description" name="purchase_description" value="{{ old('purchase_description') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('purchase_description')
                @foreach($errors->get('purchase_description') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div> 
        <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Registrar</button>   
    </form>   
</div>
@endsection
