<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login() : View {
        return view('auth.login', [
            'title' => 'Login Page',
        ]);
    }

    public function authentication(Request $request) : RedirectResponse {
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:3',
        ]);

        if (User::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        } else {
            return redirect(route('login'))->with('failed', "Email or Password Not Found!");
        }
    }

    public function register() : View {
        return view('auth.register', [
            'title' => 'Register Page',
        ]);
    }

    public function store(Request $request) : RedirectResponse {
        dd($request->all());

        try {
            return redirect(route('login'))->with('success', "Successfully Create New Account!");
        } catch (\Throwable $th) {
            return redirect(route('register'))->with('failed', "Failed Create New Account!");
        }
    }
}