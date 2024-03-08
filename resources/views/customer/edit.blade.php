@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-3" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form class="row row-cols-1" action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="col mb-3">
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col d-flex flex-column">
                            <label for="image" class="form-label">Foto Profil</label>
                            <img src="{{ file_exists('assets/images/profile/' . $customer->image) && $customer->image ? asset('assets/images/profile/' . $customer->image) : asset('assets/images/profile/profile-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-profile" width="100" height="100" style="object-fit: cover;">
                            <input type="file" class="form-control input-file-profile @error('image') is-invalid @enderror" name="image" id="image">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col d-flex flex-column">
                            <label for="photo_ktp" class="form-label">Foto KTP</label>
                            <img src="{{ file_exists('assets/images/customer/' . $customer->photo_ktp) && $customer->photo_ktp ? asset('assets/images/customer/' . $customer->photo_ktp) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-ktp" width="100" height="100" style="object-fit: cover;">
                            <input type="file" class="form-control input-file-ktp @error('photo_ktp') is-invalid @enderror" name="photo_ktp" id="photo_ktp">
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
                    <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $customer->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $customer->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="number_phone" class="form-label">Nomor Telepon</label>
                    <input required type="number" class="form-control @error('number_phone') is-invalid @enderror" id="number_phone" name="number_phone" value="{{ $customer->number_phone }}">
                    @error('number_phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="origin" class="form-label">Kota Domisili</label>
                    <input required type="text" class="form-control @error('origin') is-invalid @enderror" id="origin" name="origin" value="{{ $customer->origin }}">
                    @error('origin')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                    <input required type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ $customer->place_of_birth }}">
                    @error('place_of_birth')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                    <input required type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ $customer->date_of_birth }}">
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
                        <option {{ $customer->gender == 'L' ? 'selected' : '' }} value="L">Laki Laki</option>
                        <option {{ $customer->gender == 'P' ? 'selected' : '' }} value="P">Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input required type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $customer->address }}">
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <button type="submit" class="button-primary">Simpan Perubahan</button>
                    <a href="{{ route('customer.index') }}" class="button-dark">Batal Edit</a>
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
