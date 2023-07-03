@extends('template')

@section('content')
  
    <div class="">
        <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Lista de Categorias</h1>
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
        <div class="overflow-auto mb-8 rounded-md shadow-md shadow-neutral-400">
            <table class="w-full border border-collapse bg-gray-100 text-neutral-700">
                <thead class="border bg-gray-200">
                    <tr>
                        <th class="p-3 text-center">Código</th>
                        <th class="p-3 text-center">Nome</th>
                        <td class="p-3 text-center" colspan="2"></td>
                    </tr>
                </thead>
                <tbody class="">
                    @if(!empty($categories))
                        @foreach($categories as $category)
                            <tr class="border border-e hover:bg-gray-50 text-neutral-500">
                                <td class="py-1 text-center">{{ $category->code }}</td>
                                <td class="py-1 text-center">{{ $category->name }}</td>
                                <td class="py-1 text-center border w-16" colspan="2">
                                    <button type="submit" form="form-edit" formaction="{{ route('categories.edit', ['category' => $category->id]) }}" title="editar" alt="editar" class="rounded-md py-1 px-2 text-neutral-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svG>
                                    </button>
                                    <button type="submit" form="form-remove" formaction="{{ route('categories.destroy', ['category' => $category->id]) }}" title="remover" alt="remover" class="rounded-md py-1 px-2 text-neutral-500">
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
        
        <a href="{{ route('categories.create') }}" class="bg-green-600 rounded-md py-2 px-3 text-neutral-100 shadow-md shadow-neutral-400">Cadastrar Categoria</a>
        <div>
            @if($categories)
                {{ $categories->links() }}
            @endif
        </div>
    </div>
@endsection
