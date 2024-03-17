@extends('layouts.main')

@section('content-auth')
    <div class="col-6 p-0 d-none d-lg-flex align-items-center overflow-hidden">
        <img src="{{ asset('assets/images/auth/banner-register.jpg') }}" alt="Banner Login" class="img-fluid">
    </div>
    <div class="col-lg-6 card-auth">
        <p class="auth-title">Daftar Sebagai Reseller</p>
        <p class="auth-caption">Mari sukses bersama kami!</p>
        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input required class="form-check-input" type="hidden" name="role" id="reseller" value="reseller">
            <div class="mb-2">
                <label for="name" class="form-label">Nama</label>
                <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="number_phone" class="form-label">Whatsapp</label>
                <input required type="number" class="form-control @error('number_phone') is-invalid @enderror" id="number_phone" name="number_phone" value="{{ old('number_phone') }}">
                @error('number_phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="photo_ktp" class="form-label">Foto KTP</label>
                <div class="wrapper-ktp d-flex gap-3 align-items-center p-2 mb-2">
                    <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="KTP Image" class="rounded img-preview" width="52" height="52" style="object-fit: cover;">
                    <p class="content-other">Pastikan seluruh bagian  KTP kamu berada dalam bingkai foto</p>
                </div>
                <input required class="form-control input-file @error('photo_ktp') is-invalid @enderror" type="file" id="photo_ktp" name="photo_ktp">
                @error('photo_ktp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="wrapper mb-2 d-flex gap-3">
                <div class="wrapper w-100">
                    <label for="password" class="form-label">Password</label>
                    <input required type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="wrapper w-100">
                    <label for="confirmation_password" class="form-label">Konfirmasi Password</label>
                    <input required type="password" class="form-control {{ session()->has('failed-password') ? 'is-invalid' : '' }}" id="confirmation_password" name="confirmation_password">
                    @if (session()->has('failed-password'))
                        <div class="invalid-feedback">
                            {{ session('failed-password') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-text" id="basic-addon4">Gunakan minimal 8 karakter dengan campuran huruf, angka & simbol</div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="open_password" onclick="openPassword()">
                <label class="form-check-label" for="open_password">Tampilkan Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 text-center">Daftar</button>
        </form>
        <p class="link-redirect text-center">Sudah punya Akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>

    @push('js')
        <script>
            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });

            function openPassword() {
                const password = document.querySelector('#password');
                const confirmationPassword = document.querySelector('#confirmation_password');
                const openPassword = document.querySelector('#open_password');

                if (openPassword.checked == true) {
                    password.setAttribute("type", "text");
                    confirmationPassword.setAttribute("type", "text");
                } else {
                    password.setAttribute("type", "password");
                    confirmationPassword.setAttribute("type", "password");
                }
            }
        </script>
    @endpush
@endsection
