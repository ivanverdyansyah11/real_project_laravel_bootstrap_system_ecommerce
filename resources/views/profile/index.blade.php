@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if (session()->has('success'))
                <div class="alert alert-success w-100 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h6 class="card-body-title mb-4">Biodata Saya</h6>
                    <form class="row row-cols-1 row-cols-md-2" action="{{ route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="col mb-3 d-flex flex-column">
                            <label for="image" class="form-label">Foto Profil</label>
                            <img src="{{ file_exists('assets/images/profile/' . $profile->user->image) && $profile->user->image ? asset('assets/images/profile/' . $profile->user->image) : asset('assets/images/profile/profile-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                            <input type="file" class="form-control input-file @error('image') is-invalid @enderror" name="image" id="image">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3 d-flex flex-column">
                            <label for="photo_ktp" class="form-label">Foto KTP</label>
                            @if ($profile->user->role == 'super_admin' || $profile->user->role == 'admin')
                                <img src="{{ file_exists('assets/images/admin/' . $profile->photo_ktp) && $profile->photo_ktp ? asset('assets/images/admin/' . $profile->photo_ktp) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-ktp" width="100" height="100" style="object-fit: cover;">
                            @elseif ($profile->user->role == 'reseller')
                                <img src="{{ file_exists('assets/images/reseller/' . $profile->photo_ktp) && $profile->photo_ktp ? asset('assets/images/reseller/' . $profile->photo_ktp) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-ktp" width="100" height="100" style="object-fit: cover;">
                            @else
                                <img src="{{ file_exists('assets/images/customer/' . $profile->photo_ktp) && $profile->photo_ktp ? asset('assets/images/customer/' . $profile->photo_ktp) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-ktp" width="100" height="100" style="object-fit: cover;">
                            @endif
                            <input type="file" class="form-control input-file-ktp @error('photo_ktp') is-invalid @enderror" name="photo_ktp" id="photo_ktp">
                            @error('photo_ktp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $profile->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="number_phone" class="form-label">Nomor Telepon</label>
                            <input required type="number" class="form-control @error('number_phone') is-invalid @enderror" id="number_phone" name="number_phone" value="{{ $profile->number_phone }}">
                            @error('number_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="origin" class="form-label">Kota Domisili</label>
                            <input required type="text" class="form-control @error('origin') is-invalid @enderror" id="origin" name="origin" value="{{ $profile->origin }}">
                            @error('origin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                            <input required type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ $profile->place_of_birth }}">
                            @error('place_of_birth')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                            <input required type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ $profile->date_of_birth }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select required class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Pilih jenis kelamin</option>
                                <option {{ $profile->gender == 'L' ? 'selected' : '' }} value="L">Laki Laki</option>
                                <option {{ $profile->gender == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input required type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $profile->address }}">
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $profile->user->email }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="confirmation_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control {{ session()->has('failed-password') ? 'is-invalid' : '' }}" id="confirmation_password" name="confirmation_password">
                            @if (session()->has('failed-password'))
                                <div class="invalid-feedback">
                                    {{ session('failed-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col mb-3">
                            <input class="form-check-input" type="checkbox" id="open_password" onclick="openPassword()">
                            <label class="form-check-label" for="open_password">Tampilkan Password</label>
                        </div>
                        <div class="col d-flex justify-content-end gap-2 mt-2">
                            <button type="submit" class="button-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');
            const tagImageKTP = document.querySelector('.img-preview-ktp');
            const inputImageKTP = document.querySelector('.input-file-ktp');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });

            inputImageKTP.addEventListener('change', function() {
                tagImageKTP.src = URL.createObjectURL(inputImageKTP.files[0]);
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
