@extends('template')

@section('content')
<div>
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Detalhes da Compra</h1>
    <div class="overflow-auto mb-8 rounded-md shadow-md shadow-neutral-400">
        <table class="w-full border border-collapse bg-gray-100 text-neutral-700">
            <thead class="border bg-gray-200">
                <tr>
                    <th scope="col" colspan="2" class="p-3 text-center">Fornecedor</th>
                    <th scope="col" colspan="2" class="p-3 text-center">Nota Fiscal</th>
                </tr>  
            </thead>
            <tbody>
                <tr class="border hover:bg-gray-50">
                    <td colspan="2" class="py-3 text-center">{{ $purchase->supplier }}</td>
                    <td colspan="2" class="py-3 text-center">{{ $purchase->invoice }}</td>
                </tr>
                <tr class="border bg-gray-200">
                    <th class="p-3 text-center" colspan="5" scope="col">Itens</th>
                </tr>
                <tr class="border">
                    <th scope="col" class="p-3 text-center">Código</th>
                    <th scope="col" class="p-3 text-center">Descrição</th>
                    <th scope="col" class="p-3 text-center">Quantidade</th>
                    <th scope="col" class="p-3 text-center">Preço</th>
                </tr>
            @foreach($purchase->items as $item)
                    <tr class="border  hover:bg-gray-50">
                        <td scope="col" class="p-3 text-center">{{ $item->code }}</td>
                        <td scope="col" class="p-3 text-center">{{ $item->description }}</td>
                        <td scope="col" class="p-3 text-center">{{ $item->quantity }}</td>
                        <td scope="col" class="p-3 text-center border">{{ $item->price }}</td>
                    </tr>
            @endforeach
            <tr class="border">
                    <th class="p-3 text-center bg-gray-200" scope="row" colspan="3">Total</th>
                    <td class="p-3 border text-center font-bold" >{{ $purchase->total_value }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <a href="{{ route('purchases.index') }}" class="bg-blue-500 rounded-md py-2 px-3 text-neutral-100 mt-4 shadow-md shadow-neutral-400">Voltar à Lista de Compras</a>
</div>
@endsection
