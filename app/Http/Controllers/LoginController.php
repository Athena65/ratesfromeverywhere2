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
            return redirect()->intended('/'); // Başarılı giriş yapıldığında ana sayfaya yönlendirme
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz bilgiler yanlış.',
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
