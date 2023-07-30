@extends('template')

@section('content')
    <div>
        <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Detalhes da Venda</h1>
        <div class="overflow-auto mb-8 rounded-md shadow-md shadow-neutral-400">
            <table class="w-full border border-collapse bg-gray-100 text-neutral-700">
                    <tr>
                        <th  colspan="4" scope="col" class="p-3 text-start border bg-gray-200">Dados do Cliente</th>
                    </tr>    
                    <tr>
                        <td colspan="4" class="p-3 border">{{ $sale->client_data }}</td>
                    </tr>
                    <tr>
                        <th  colspan="4" scope="col" class="p-3 text-center border bg-gray-200">Itens</th>
                    </tr>
                    <tr class="border">
                        <th  scope="col" scope="col" class="p-3 text-center">Código</th>
                        <th  scope="col" scope="col" class="p-3 text-center">Descrição</th>
                        <th  scope="col" scope="col" class="p-3 text-center">Quantidade</th>
                        <th  scope="col" scope="col" class="p-3 text-center">Preço</th>
                    </tr>
                    @foreach($sale->items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 text-center">{{ $item->product_code }}</td>
                        <td class="p-3 text-center">{{ $item->product_description }}</td>
                        <td class="p-3 text-center">{{ $item->quantity }}</td>
                        <td class="p-3 text-center">{{ $item->item_price }}</td>
                    </tr>
                    @endforeach 
                    <tr class="border">
                        <th colspan="3" scope="row" class="p-3 border text-start">Desconto</th>
                        <td class="font-bold text-center">{{ $sale->discount }}</td>
                    </tr>
                    <tr>
                        <th colspan="3" scope="row" class="p-3 border text-start">Total</th>
                        <td class="font-bold text-center">{{ $sale->total_value }}</td>
                    </tr>                 
            </table>
        </div>
        <a href="{{ route('sales.index') }}" class="bg-blue-500 rounded-md py-2 px-3 text-neutral-100 mt-4 shadow-md shadow-neutral-400">Voltar à Lista de Vendas</a>
    </div>
@endsection
