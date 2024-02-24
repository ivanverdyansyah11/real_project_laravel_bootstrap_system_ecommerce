<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterResellerRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly AuthRepository $authRepository
    ) {}
    
    public function login() : View {
        return view('auth.login', [
            'title' => 'Login Page',
        ]);
    }

    public function authentication(Request $request) : RedirectResponse {
        try {
            if (auth()->attempt($request->only("email", "password"))) {
                $user = auth()->user();
                if ($user->status == 0) {
                    auth()->logout();
                    return redirect()->back()->with('failed', 'Akun belum diaktifkan!');
                } else { 
                    return redirect()->route("dashboard.index")->with('success', 'Berhasil login akun!');
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->back()->with('failed', 'Email atau password tidak ditemukan!');
        }
    }

    public function register() : View {
        return view('auth.register', [
            'title' => 'Register Page',
        ]);
    }

    public function store(RegisterResellerRequest $request) : RedirectResponse {
        try {
            if ($request->password !== $request->confirmation_password) {
                return redirect(route('register'))->with('failed-password', "Password tidak sesuai!");
            }
            $this->authRepository->createUser($request);
            return redirect(route('login'))->with('success', "Berhasil membuat akun baru!");
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('register'))->with('failed', "Gagal membuat akun baru!");
        }
    }

    public function logout(Request $request) {
        try {
            $this->authRepository->logout($request);
            return redirect()->route("login")->with('success', 'Berhasil logout akun!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->route("dashboard.index")->with('error', 'Gagal logout akun!');
        }
    }
}