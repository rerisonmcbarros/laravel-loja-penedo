@extends('template')

@section('content')
<div>
    <h1>Finalizar Venda</h1>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="client_data">Dados do Cliente</label>
            <input type="text" id="client_data" name="client_data" value="{{ old('client_data') }}">
            @error('client_data')
                @foreach($errors->get('client_data') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="total_value">Valor Total</label>
            <input readonly type="text" id="total_value" name="total_value" value="{{ $cart->getTotal() }}">
            @error('total_value')
                @foreach($errors->get('total_value') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="discount">Desconto</label>
            <input type="text" id="discount" name="discount" value="{{ old('discount') }}">
            @error('discount')
                @foreach($errors->get('discount') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="payment">Pagamento</label>
            <input type="text" id="payment" name="payment" value="{{ old('payment') }}">
            @error('payment')
                @foreach($errors->get('payment') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button>Registrar Venda</button>
    </form>
    <a href="{{ route('cart.index') }}">Voltar ao Carrinho de Compras</a>
</div>
@endsection