<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Login formunu gösterecek metot
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login işlemi
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Başarılı giriş mesajı
            return redirect()->intended('/')
                ->with('success', __('messages.login_successful'));
        }

        return back()->withErrors([
            'email' => __('messages.invalid_credentials'),
        ]);
    }
 //commit pushdeneme
    // Logout işlemi
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
