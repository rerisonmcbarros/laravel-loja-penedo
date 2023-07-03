@extends('template')

@section('content')
    <h1 class="p-3 mb-8 bg-neutral-900 text-neutral-200 text-lg rounded-md shadow-md shadow-neutral-400">Lista de Vendas</h1>
    <div>
        @if(session()->has('message'))
            <div>{{ session()->get('message') }}</div>
        @endif
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
        <form  id="find-by-period" action="{{ route('sales.period') }}" method="get" class="flex flex-col border rounded-md shadow-md p-5 bg-gray-50 mb-8">
            <fieldset>
                <legend class="mb-3">Buscar por Período</legend>
                <div>
                    <label for="data_inicio" class="block text-neutral-900 mb-2">Data início</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                </div>
                @error('data_inicio')
                    @foreach($errors->get('data_inicio') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
                <div>
                    <label for="data_fim" class="block text-neutral-900 mb-2">Data fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="w-full p-2 rounded-md border-0 outline-0 ring-1 ring-inset ring-gray-300 focus:ring focus:ring-inset focus:ring-neutral-800  text-gray-600 mb-4">
                </div>
                @error('data_fim')
                    @foreach($errors->get('data_fim') as $error)
                        <div class="-mt-4 mb-3 font-light text-red-500 text-sm">{{ $error }}</div>
                    @endforeach
                @enderror
                <button form="find-by-period" class="w-max bg-blue-500 rounded-md py-2 px-3 text-neutral-100 mt-2 shadow-md shadow-neutral-400">Buscar</button>
            </fieldset> 
        </form>

        <div class="overflow-auto mb-8 rounded-md shadow-md shadow-neutral-400">
            <form id="form-remove" method="POST">
                @csrf() 
                @method('DELETE')
            </form>
            <form id="form-show" method="POST">
                @csrf() 
                @method('GET')
            </form>
            <table class="w-full border border-collapse bg-gray-100 text-neutral-700">
                <thead class="border bg-gray-200">
                    <tr>
                        <th scope="col" class="p-3 text-center">Cliente</th>
                        <th scope="col" class="p-3 text-center">Valor Total</th>
                        <th scope="col" class="p-3 text-center">Desconto</th>
                        <th scope="col" class="p-3 text-center">Pagamento</th>
                        <th scope="col" class="p-3 text-center">Data</th>
                        <th scope="col" class="p-3 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($sales))
                        @foreach($sales as $sale)
                            <tr class="border border-e hover:bg-gray-50 text-neutral-500">
                                <td class="py-1 text-center">{{ $sale->client_data }}</td>
                                <td class="py-1 text-center">{{ $sale->total_value }}</td>
                                <td class="py-1 text-center">{{ $sale->discount }}</td>
                                <td class="py-1 text-center">{{ $sale->payment }}</td>
                                <td class="py-1 text-center">{{ $sale->created_at }}</td>
                                <td class="py-1 text-center border w-16">
                                    <button type="submit" form="form-show" formaction="{{ route('sales.show', ['sale' => $sale->id]) }}" title="ver detalhes">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>  
                                    </button>
                                    <button type="submit" form="form-remove" formaction="{{ route('sales.destroy', ['sale' => $sale->id]) }}" title="remover">
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
    </div>

    @if(!empty($sales)) 
        {{ $sales->links() }}
    @endif
    
@endsection
