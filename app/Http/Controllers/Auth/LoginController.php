<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            Alert::success('Success', 'Login Success');
            return redirect()->intended(route('index'));
        }else{
            Alert::error('Failed', 'Login Failed');
        }

        throw ValidationException::withMessages([

            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
        Alert::success('Success', 'Logout Success');
    }
}