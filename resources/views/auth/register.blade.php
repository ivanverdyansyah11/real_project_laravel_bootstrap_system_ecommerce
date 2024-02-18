@extends('layouts.main')

@section('content-auth')
    <div class="col-6 p-0 d-none d-lg-flex align-items-center overflow-hidden">
        <img src="{{ asset('assets/images/auth/banner-register.jpg') }}" alt="Banner Login" class="img-fluid">
    </div>
    <div class="col-lg-6 card-auth">
        <p class="auth-title">Daftar Sebagai Reseller</p>
        <p class="auth-caption">Mari sukses bersama kami!</p>
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label class="form-label">Daftar sebagai</label>
                <div class="wrapper d-flex gap-4">
                    <div class="form-check m-0">
                        <input class="form-check-input" type="radio" name="role" id="customer">
                        <label class="form-check-label" for="customer">Customer</label>
                    </div>
                    <div class="form-check m-0">
                        <input class="form-check-input" type="radio" name="role" id="reseller">
                        <label class="form-check-label" for="reseller">Reseller</label>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name">
            </div>
            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-2">
                <label for="whatsapp" class="form-label">Whatsapp</label>
                <input type="number" class="form-control" id="whatsapp">
            </div>
            <div class="mb-2">
                <label for="formFile" class="form-label">Foto KTP</label>
                <input class="form-control input-file" type="file" id="formFile">
                <div class="wrapper-ktp d-flex gap-3 align-items-center p-2">
                    <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="KTP Image" class="img-fluid rounded img-preview" width="52" height="52" style="object-fit: cover;">
                    <p class="content-other">Pastikan seluruh bagian  KTP kamu berada dalam bingkai foto</p>
                </div>
            </div>
            <div class="wrapper mb-2 d-flex gap-3">
                <div class="wrapper w-100">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="wrapper w-100">
                    <label for="confirmation_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirmation_password">
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