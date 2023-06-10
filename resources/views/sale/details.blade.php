@extends('template')

@section('content')
    <div>
        <h1>Detalhes da Venda</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="4" scope="col">Detalhes da Venda</th>
                </tr>
            </thead>
            <tbody>       
                <tr>
                    <th colspan="4" scope="col">Dados do Cliente</th>
                </tr>
                <tr>
                    <td colspan="4">{{ $sale->client_data }}</td>
                </tr>
                <tr>
                    <th colspan="4" scope="col">Itens</th>
                </tr>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Preço</th>
                </tr>
                @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->product_description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->item_price }}</td>
                </tr>
                @endforeach 
                <tr>
                    <th colspan="3" scope="row">Desconto</th>
                    <td>{{ $sale->discount }}</td>
                </tr>
                <tr>
                    <th colspan="3" scope="row">Total</th>
                    <td>{{ $sale->total_value }}</td>
                </tr>                
            </tbody>  
        </table>
    </div>
@endsection