@extends('layouts.main')

@section('content-auth')
    <div class="col-6 p-0 d-none d-lg-inline-block overflow-hidden" style="height: 100vh !important;">
        <img src="{{ asset('assets/images/auth/banner-login.jpg') }}" alt="Banner Login" class="img-fluid banner-auth">
    </div>
    <div class="col-lg-6 card-auth">
        <p class="auth-title">Selamat Datang Kembali</p>
        <p class="auth-caption">Hallo sahabat sehat, silahkan untuk Login dulu!</p>
        @if (session()->has('success'))
            <div class="alert alert-success w-100 mb-3" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session()->has('failed'))
            <div class="alert alert-danger w-100 mb-3" role="alert">
                {{ session('failed') }}
            </div>
        @endif
        <form action="{{ route('login.authentication') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="open_password" onclick="openPassword()">
                <label class="form-check-label" for="open_password">Tampilkan Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 text-center">Login</button>
        </form>
        <p class="link-redirect text-center">Belum punya Akun? <a href="{{ route('register') }}">Buat Akun</a></p>
    </div>

    @push('js')
        <script>
            function openPassword() {
                const password = document.querySelector('#password');
                const openPassword = document.querySelector('#open_password');
    
                if (openPassword.checked == true) {
                    password.setAttribute("type", "text");
                } else {
                    password.setAttribute("type", "password");
                }
            }
        </script>
    @endpush
@endsection