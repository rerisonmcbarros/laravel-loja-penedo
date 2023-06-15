@extends('template')

@section('content')
    <h1>Lista de Compras</h1>
    <div>
        <form id="form-show" method="GET">
        </form>
        <form id="form-remove" method="POST">
            @csrf() 
            @method('DELETE')
        </form>
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
        <form  id="find-by-period" action="{{ route('purchases.period') }}" method="">
            <fieldset>
                <legend>Buscar por Período</legend>
                <div>
                    <label for="data_inicio">Data início</label>
                    <input type="date" id="data_inicio" name="data_inicio">
                </div>
                @error('data_inicio')
                    @foreach($errors->get('data_inicio') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @enderror
                <div>
                    <label for="data_fim">Data fim</label>
                    <input type="date" id="data_fim" name="data_fim">
                </div>
                @error('data_fim')
                    @foreach($errors->get('data_fim') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @enderror
                <button form="find-by-period">Buscar</button>
            </fieldset> 
        </form>
        <table>
            <thead>
                <tr>
                    <th>Fornecedor</th>
                    <th>Nota Fiscal</th>
                    <th>Descrição</th>
                    <th>Valor Total</th>
                    <th>Data</th>
                    <td colspan="2"></td>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->supplier }}</td>
                        <td>{{ $purchase->invoice }}</td>
                        <td>{{ $purchase->description }}</td>
                        <td>{{ $purchase->total_value }}</td>
                        <td>{{ $purchase->created_at }}</td>
                        <td colspan="2">
                            <button type="submit" form="form-show" formaction="{{ route('purchases.show', ['purchase' => $purchase->id]) }}">Detalhes</button>
                            <button type="submit" form="form-remove" formaction="{{ route('purchases.destroy', ['purchase' => $purchase->id]) }}">Remover</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('purchases.create') }}">Cadastrar nova Compra</a>
    </div>

    @if(!empty($purchases)) 
        {{ $purchases->links() }}
    @endif
    
@endsection