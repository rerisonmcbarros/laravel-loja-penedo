@extends('template')

@section('content')
<div>
    <h1>Carrinho de Compras</h1>
    <form id="form-remove" method="POST">
        @csrf() 
        @method('DELETE')
    </form>
    <form action="{{ route('cart.addItem') }}" method="POST">
        @csrf
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        <div>
            <label for="product_code">Código do Produto</label>
            <input type="text" id="product_code" name="product_code" value="{{ old('product_code') }}">
            @error('product_code')
                @foreach($errors->get('product_code') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="quantity">Quantidade</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}">
            @error('quantity')
                @foreach($errors->get('quantity') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button>Adicionar ao Carrinho</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->getItems() as $item)
                <tr>
                    <td>{{ $item->getProduct()->code }}</td>
                    <td>{{ $item->getProduct()->description }}</td>
                    <td>{{ $item->getQuantity() }}</td>
                    <td>{{ $item->getProduct()->sale_price }}</td>
                    <td>
                        <button type="submit" form="form-remove" formaction="{{ route('cart.removeItem', ['item' => $item->getProduct()->id]) }}">Remover</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total</td>
                <td>
                    {{ $cart->getTotal() }}
                </td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('sales.create') }}">Registrar Venda</a>
</div>
@endsection