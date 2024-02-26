@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-3" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form class="row row-cols-1" action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="customer" name="role">
                <input type="hidden" value="1" name="status">
                <div class="col mb-3">
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col d-flex flex-column">
                            <label for="image" class="form-label">Foto Profil</label>
                            <img src="{{ asset('assets/images/profile/profile-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-profile" width="100" height="100" style="object-fit: cover;">
                            <input required type="file" class="form-control input-file-profile @error('image') is-invalid @enderror" name="image" id="image">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col d-flex flex-column">
                            <label for="photo_ktp" class="form-label">Foto KTP</label>
                            <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-ktp" width="100" height="100" style="object-fit: cover;">
                            <input required type="file" class="form-control input-file-ktp @error('photo_ktp') is-invalid @enderror" name="photo_ktp" id="photo_ktp">
                            @error('photo_ktp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input required type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="number_phone" class="form-label">Nomor Telepon</label>
                    <input required type="number" class="form-control @error('number_phone') is-invalid @enderror" id="number_phone" name="number_phone" value="{{ old('number_phone') }}">
                    @error('number_phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <button type="submit" class="button-primary">Tambah Pelanggan</button>
                    <a href="{{ route('customer.index') }}" class="button-dark">Batal Tambah</a>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            const tagImageProfile = document.querySelector('.img-preview-profile');
            const inputImageProfile = document.querySelector('.input-file-profile');
            const tagImageKTP = document.querySelector('.img-preview-ktp');
            const inputImageKTP = document.querySelector('.input-file-ktp');

            inputImageProfile.addEventListener('change', function() {
                tagImageProfile.src = URL.createObjectURL(inputImageProfile.files[0]);
            });

            inputImageKTP.addEventListener('change', function() {
                tagImageKTP.src = URL.createObjectURL(inputImageKTP.files[0]);
            });
        </script>
    @endpush
@endsection
