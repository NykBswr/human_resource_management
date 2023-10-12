<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('signin.main');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'identity' => 'required',
            'password' => 'required',
        ]);

        $user = User::where(function ($query) use ($credentials) {
            $query->where('username', $credentials['identity'])
                ->orWhere('email', $credentials['identity']);
        })->first();

        if (!$user) {
            return back()->with('loginError', 'Invalid credentials');
        }

        if (!Auth::attempt(['username' => $user->username, 'password' => $credentials['password']])) {
            return back()->with('loginError', 'Invalid credentials');
        }

        $remember = $request->input('remember');
        if (Auth::attempt(['username' => $user->username, 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended("/dashboard");
        }
        return back()->with('loginError', 'Login fail!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}
