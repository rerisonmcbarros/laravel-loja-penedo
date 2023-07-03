@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Finalizar Venda</h1>
    <form action="{{ route('sales.store') }}" method="POST" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
        @csrf
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="client_data" class="block text-neutral-900 mb-2">Dados do Cliente</label>
            <input type="text" id="client_data" name="client_data" value="{{ old('client_data') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('client_data')
                @foreach($errors->get('client_data') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="total_value" class="block text-neutral-900 mb-2">Valor Total</label>
            <input readonly type="text" id="total_value" name="total_value" value="{{ $cart->getTotal() }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('total_value')
                @foreach($errors->get('total_value') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="discount" class="block text-neutral-900 mb-2">Desconto</label>
            <input type="text" id="discount" name="discount" value="{{ old('discount') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('discount')
                @foreach($errors->get('discount') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="payment" class="block text-neutral-900 mb-2">Pagamento</label>
            <input type="text" id="payment" name="payment" value="{{ old('payment') }}" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
            @error('payment')
                @foreach($errors->get('payment') as $error)
                    <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button class="w-max bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Registrar Venda</button>
    </form>
    <a href="{{ route('cart.index') }}" class="bg-blue-500 rounded-md py-2 px-3 text-neutral-100 mt-4 shadow-md shadow-neutral-400">Voltar ao Carrinho de Compras</a>
</div>
@endsection
