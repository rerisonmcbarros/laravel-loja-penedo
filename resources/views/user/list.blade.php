@extends('template')

@section('content')
    <h1>Lista de Usuários</h1>
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
        @if(!empty($message))
            <div>{{ $message }}</div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <td colspan="2"></td>
                </tr>
            </thead>
            <tbody>
                @if(!empty($users))
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin }}</td>
                            <td colspan="2">
                                <button type="submit" form="form-edit" formaction="{{ route('users.edit', ['user' => $user->id]) }}">Editar</button>
                                <button type="submit" form="form-remove" formaction="{{ route('users.destroy', ['user' => $user->id]) }}">Remover</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <a href="{{ route('users.create') }}">Cadastrar Usuário</a>
    </div>

    @if(!empty($users)) 
        {{ $users->links() }}
    @endif
    
@endsection