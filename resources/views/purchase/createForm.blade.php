@extends('template')

@section('content')
<div>
    <h1>Registar Compra</h1>
    <h2>Itens</h2>
    @if(session()->has('message'))
        <div>{{ session()->get('message') }}</div>
    @endif
    <form id="form-remove" method="POST">
        @csrf() 
        @method('DELETE')
    </form>
    <form action="{{ route('purchases.addItem') }}" method="POST">
        @csrf
        <div>
            <label for="code">Código do Produto</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}">
            @error('code')
                @foreach($errors->get('code') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="description">Descrição</label>
            <input type="text" id="description" name="description" value="{{ old('description') }}">
            @error('description')
                @foreach($errors->get('description') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="price">Preço</label>
            <input type="text" id="price" name="price" value="{{ old('price') }}">
            @error('price')
                @foreach($errors->get('price') as $error)
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
        <button>Adicionar Item</button>
    </form>
    <table>
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Descrição</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Preço</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->getItems() as $index => $item)        
                <tr>
                    <td>{{ $item->getCode() }}</td>
                    <td>{{ $item->getDescription() }}</td>
                    <td>{{ $item->getQuantity() }}</td>
                    <td>{{ $item->getPrice() }}</td>
                    <td>
                        <button type="submit" form="form-remove" formaction="{{ route('purchases.removeItem', ['item' => $index]) }}">Remover</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="4" scope="row">Total</th>
                <td>
                    {{ $purchase->getTotal() }}
                </td>
            </tr>
        </tbody>
    </table>
    <form id="form-store" method="POST">
        @csrf
        <div>
            <label for="supplier">Fornecedor</label>
            <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}">
            @error('supplier')
                @foreach($errors->get('supplier') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="invoice">Nota Fiscal</label>
            <input type="text" id="invoice" name="invoice" value="{{ old('invoice') }}">
            @error('invoice')
                @foreach($errors->get('invoice') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <div>
            <label for="purchase_description">Descrição</label>
            <input type="text" id="purchase_description" name="purchase_description" value="{{ old('purchase_description') }}">
            @error('purchase_description')
                @foreach($errors->get('purchase_description') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
        </div>
        <button form="form-store" formaction="{{ route('purchases.store') }}">Registrar Compra</button>
    </form>   
</div>
@endsection