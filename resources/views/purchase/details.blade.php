@extends('template')

@section('content')
<div>
    <table>
        <thead>
            <tr>
                <th scope="col">Fornecedor</th>
                <th scope="col">Nota Fiscal</th>
                <th scope="col">Data</th>
            </tr>  
        </thead>
        <tbody>
            <tr>
                <td>{{ $purchase->supplier }}</td>
                <td>{{ $purchase->invoice }}</td>
                <td>{{ $purchase->created_at }}</td>
            </tr>
            <tr>
                <th colspan="3" scope="col">Itens</th>
            </tr>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Descrição</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Preço</th>
                <th scope="col"></th>
            </tr>
           @foreach($purchase->items as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->getSubTotal() }}</td>
                </tr>
           @endforeach
           <tr>
                <th scope="row" colspan="4">Total</th>
                <td>{{ $purchase->total_value }}</td>
           </tr>
        </tbody>
    </table>
    <a href="{{ route('purchases.index') }}">Voltar à Lista de Compras</a>
</div>
@endsection