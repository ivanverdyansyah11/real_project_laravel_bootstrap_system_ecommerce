<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterResellerRequest;
use App\Models\User;
use App\Repositories\AdminRepositories;
use App\Repositories\AuthRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly AdminRepositories $admin,
    ) {
    }

    public function login(): View
    {
        return view('auth.login', [
            'title' => 'Login Page',
        ]);
    }

    public function authentication(Request $request): RedirectResponse
    {
        try {
            if (auth()->attempt($request->only("email", "password"))) {
                $user = auth()->user();
                $admin = $this->admin->findFirst();
                if ($user->status == 0) {
                    auth()->logout();
                    return redirect()->back()->with('failed', "Akun belum diaktifkan oleh admin (" . $admin->number_phone . ")! Silahkan menunggu persetujuan admin.");
                } else {
                    if (auth()->user()->role == 'customer') {
                        return redirect()->route("homepage")->with('success', 'Berhasil login akun!');
                    } else {
                        return redirect()->route("dashboard.index")->with('success', 'Berhasil login akun!');
                    }
                }
            } else {
                return redirect()->back()->with('failed', 'Email atau password tidak ditemukan!');
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->back()->with('failed', 'Terjadi kesalahan! Silakan coba lagi nanti.');
        }
    }

    public function register(): View
    {
        return view('auth.register', [
            'title' => 'Register Page',
        ]);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            if ($request->password !== $request->confirmation_password) {
                return redirect(route('register'))->with('failed-password', "Password tidak sesuai!");
            }
            $admin = $this->admin->findFirst();
            $this->authRepository->createUser($request->validated());
            return redirect(route('login'))->with('success', "Pendaftaran berhasil, Silahkan hubungi admin (" . $admin->number_phone . ") untuk pengaktifan akun!");
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('register'))->with('failed', "Gagal membuat akun baru!");
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authRepository->logout($request);
            return redirect()->route("login")->with('success', 'Berhasil logout akun!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->route("dashboard.index")->with('error', 'Gagal logout akun!');
        }
    }
}
