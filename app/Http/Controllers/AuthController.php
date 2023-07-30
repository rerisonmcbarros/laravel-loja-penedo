<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttemptAuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (Auth::user()) {
            Session::regenerate();
            return redirect()->route('sales.index');
        }

        return view('login.form', [
            'title' => 'Penedo | Login'
        ]);
    }

    public function attempt(AttemptAuthRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];
    
        if (Auth::attempt($credentials)) {
            Session::regenerateToken();
            return redirect()->route('sales.index');
        }

        return redirect()->route('auth.login')->withErrors([
            'message' => 'Email ou senha inválidos.'
        ])->withInput($request->only(['email']));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerate();
        return redirect()->route('auth.login');
    }
}
