@extends('template')

@section('content')
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Lista de Produtos</h1>
    <div>
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
        <form action="{{ route('products.byCategory') }}" method="get" class="flex flex-col sm:flex-row border rounded-md shadow-md p-5 bg-gray-50 mb-8">
            <div class="sm:me-4 sm:w-2/3">
                <label for="find-by-category" class="block text-neutral-900 mb-2">Buscar por Categoria</label>
                <select name="categoria" id="find-by-category" class="w-full p-2.5 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-900 mb-4">
                    <option value=""></option>
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
            <div>
                <button class="w-max bg-blue-500 rounded-md py-2 px-3 sm:mt-8 text-neutral-100 mt-2 shadow-md shadow-neutral-400">Buscar</button>
            </div>
        </form>

        <div class="overflow-auto mb-8 rounded-md shadow-md shadow-neutral-400">
            <form id="form-edit" method="get">
            </form>
            <form id="form-remove" method="post">
                @csrf() 
                @method('DELETE')
            </form>
           
            <table class="w-full border border-collapse bg-gray-100 text-neutral-700">
                <thead class="border bg-gray-200">
                    <tr>
                        <th scope="col" class="p-3 text-center">Categoria</th>
                        <th scope="col" class="p-3 text-center">Código</th>
                        <th scope="col" class="p-3 text-center">Descrição</th>
                        <th scope="col" class="p-3 text-center">Preço de Custo</th>
                        <th scope="col" class="p-3 text-center">Preço de Venda</th>
                        <th scope="col" class="p-3 text-center">Estoque</th>
                        <th scope="col" class="p-3 text-center" colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($products))
                        @foreach($products as $product)
                            <tr class="border border-e hover:bg-gray-50 text-neutral-500">
                                <td class="py-1 text-center">{{ $product->category->name }}</td>
                                <td class="py-1 text-center">{{ $product->code }}</td>
                                <td class="py-1 text-center">{{ $product->description }}</td>
                                <td class="py-1 text-center">{{ $product->purchase_price }}</td>
                                <td class="py-1 text-center">{{ $product->sale_price }}</td>
                                <td class="py-1 text-center">{{ $product->storage }}</td>
                                <td class="py-1 text-center border" colspan="2">
                                    <button type="submit" form="form-edit" formaction="{{ route('products.edit', ['product' => $product->id]) }}" title="editar" alt="editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <button type="submit" form="form-remove" formaction="{{ route('products.destroy', ['product' => $product->id]) }}" title="remover" alt="remover">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg> 
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <a href="{{ route('products.create') }}" class="bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Cadastrar Produto</a>
    </div>

    @if(!empty($products)) 
        {{ $products->links() }}
    @endif
    
@endsection
