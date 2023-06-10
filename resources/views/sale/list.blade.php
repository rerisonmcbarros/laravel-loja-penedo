@extends('template')

@section('content')
    <h1>Lista de Vendas</h1>
    <div>
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
        <form  id="find-by-period" action="{{ route('sales.period') }}" method="">
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

        <form id="form-remove" method="POST">
            @csrf() 
            @method('DELETE')
        </form>
        <form id="form-show" method="POST">
            @csrf() 
            @method('GET')
        </form>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Valor Total</th>
                    <th>Desconto</th>
                    <th>Pagamento</th>
                    <th>Data</th>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @if(!empty($sales))
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->client_data }}</td>
                            <td>{{ $sale->total_value }}</td>
                            <td>{{ $sale->discount }}</td>
                            <td>{{ $sale->payment }}</td>
                            <td>{{ $sale->created_at }}</td>
                            <td>
                                <button type="submit" form="form-show" formaction="{{ route('sales.show', ['sale' => $sale->id]) }}">Detalhes</button>
                                <button type="submit" form="form-remove" formaction="{{ route('sales.destroy', ['sale' => $sale->id]) }}">Remover</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @if(!empty($sales)) 
        {{ $sales->links() }}
    @endif
    
@endsection