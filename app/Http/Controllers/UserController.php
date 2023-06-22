<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            $users = User::paginate(15);
        } catch (Exception $e) {
            $message = 'Erro, não foi possível obter a lista de usuários.';
        }
        return view('user.list', [
            'title' => 'Penedo | Lista de Usuários',
            'users' => $users ?? [],
            'message' => $message ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('user.createForm', [
            'title' => 'Penedo | Cadastrar Usuário'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = $request->get('password');
            
            if ($request->get('is_admin')) {
                $user->is_admin = $request->get('is_admin');  
            }
            
            $user->save();
        
            DB::commit();
            Session::flash('message', 'Usuário cadastrado com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('message', 'Erro, não foi possível efetuar o cadastro de usuário.');
            return redirect()->route('users.create');
        }

        return redirect()->route('users.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::query()->find($id);

            if (empty($user)) {
                Session::flash('message', 'Não foi possível editar, usuário não encontrado.');
                return redirect()->route('users.index');
            }
        } catch (Exception $e) {
            Session::flash('message', 'Erro, Não foi possível editar usuário.');
            return redirect()->route('users.index');
        }

        return view('user.editForm', [
            'title' => 'Penedo | Editar Usuário',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $user = User::query()->find($id);
            
            if (empty($user)) {
                Session::flash('message', 'Não foi possível editar, usuário não encontrado.');
                return redirect()->route('users.index');
            }

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = $request->get('password');
            
            if ($request->get('is_admin')) {
                $user->is_admin = $request->get('is_admin');  
            }
            
            $user->save();

            DB::commit();
            Session::flash('message', 'Usuário atualizado com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('message', 'Erro, não foi possível editar usuário.');
            return redirect()->route('users.edit');
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);

            if (empty($user)) {
                Session::flash('message', 'Erro, o usuário informado não foi encontrado.');
                return redirect()->route('users.index');
            }

            $user->delete();
            DB::commit();
            $message = 'Usuário removido com sucesso.';   
        } catch (Exception $e) {
            $message = 'Erro, não foi possível remover usuário.';
            DB::rollBack();
        }

        Session::flash('message', $message);
        return redirect()->route('users.index');
    }
}
