@extends('template')

@section('content')
    <h1>Listagem de Categorias</h1>
    <div>
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
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <td colspan="2"></td>
                </tr>
            </thead>
            <tbody>
                @if(!empty($categories))
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->code }}</td>
                            <td>{{ $category->name }}</td>
                            <td colspan="2">
                                <button type="submit" form="form-edit" formaction="{{ route('categories.edit', ['category' => $category->id]) }}">Editar</button>
                                <button type="submit" form="form-remove" formaction="{{ route('categories.destroy', ['category' => $category->id]) }}">Remover</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <a href="{{ route('categories.create') }}">Cadastrar Categoria</a>
    </div>
@endsection