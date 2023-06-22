@extends('template')

@section('content')
    <h1>Lista de Produtos</h1>
    <div>
        <form action="{{ route('products.by.category') }}" method="GET">
            <div>
                <label for="find-by-category">Buscar por Categoria</label>
                <select name="categoria" id="find-by-category">
                    @foreach($categories as $category)
                        <option @selected($category->id == $selected) value="{{ $category->code }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                @foreach($errors->get('category_id') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @enderror
            <button>Buscar</button>
        </form>
        <form id="form-edit" method="POST">
            @csrf()
            @method('GET')
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
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Preço de Custo</th>
                    <th>Preço de Venda</th>
                    <th>Estoque</th>
                    <td colspan="2"></td>
                </tr>
            </thead>
            <tbody>
                @if(!empty($products))
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->purchase_price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>{{ $product->storage }}</td>
                            <td colspan="2">
                                <button type="submit" form="form-edit" formaction="{{ route('products.edit', ['product' => $product->id]) }}">Editar</button>
                                <button type="submit" form="form-remove" formaction="{{ route('products.destroy', ['product' => $product->id]) }}">Remover</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <a href="{{ route('products.create') }}">Cadastrar Produto</a>
    </div>

    @if(!empty($products)) 
        {{ $products->links() }}
    @endif
    
@endsection
