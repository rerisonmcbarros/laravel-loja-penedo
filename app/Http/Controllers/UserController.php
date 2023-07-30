<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $users = User::paginate(15);
        
        return view('user.list', [
            'title' => 'Penedo | Lista de Usuários',
            'users' => $users ?? [],
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
            $user->is_admin = $request->get('is_admin');  
        
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
        $user = User::query()->findOrFail($id);
          
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
        $user = User::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = $request->get('password');

            if ($request->has('is_admin')) {
                $user->is_admin = $request->get('is_admin');  
            } else {
                $user->is_admin = $user->is_admin;
            }
                        
            $user->save();

            DB::commit();

            Session::flash('message', 'Usuário atualizado com sucesso.');

            if (Auth::user()->id == $user->id) {
                return redirect()->route('auth.logout');
            }
            
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('message', "Erro, não foi possível atualizar usuário");
            return redirect()->back();
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $user->delete();
            
            DB::commit();
            Session::flash('message', 'Usuário removido com sucesso.');   
        } catch (Exception $e) {
            Session::flash('message', 'Erro, não foi possível remover usuário.');
            DB::rollBack();
        }

        return redirect()->route('users.index');
    }
}
