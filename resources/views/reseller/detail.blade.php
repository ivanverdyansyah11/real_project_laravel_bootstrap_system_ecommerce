@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-3" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form class="row row-cols-1">
                <div class="col mb-3">
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col d-flex flex-column">
                            <label for="image" class="form-label">Foto Profil</label>
                            <img src="{{ file_exists('assets/images/profile/' . $reseller->user->image) && $reseller->user->image ? asset('assets/images/profile/' . $reseller->user->image) : asset('assets/images/profile/profile-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-profile" width="100" height="100" style="object-fit: cover;">
                        </div>
                        <div class="col d-flex flex-column">
                            <label for="photo_ktp" class="form-label">Foto KTP</label>
                            <img src="{{ file_exists('assets/images/reseller/' . $reseller->photo_ktp) && $reseller->photo_ktp ? asset('assets/images/reseller/' . $reseller->photo_ktp) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview-ktp" width="100" height="100" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input readonly type="text" class="form-control" id="name" value="{{ $reseller->name }}">
                </div>
                <div class="col mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input readonly type="email" class="form-control" id="email" value="{{ $reseller->user->email }}">
                </div>
                <div class="col mb-3">
                    <label for="number_phone" class="form-label">Nomor Telepon</label>
                    <input readonly type="number" class="form-control" id="number_phone" value="{{ $reseller->number_phone }}">
                </div>
                <div class="col mb-3">
                    <label for="poin" class="form-label">Poin</label>
                    <input readonly type="number" class="form-control" id="poin" value="{{ $reseller->poin }}">
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <a href="{{ route('reseller.index') }}" class="button-dark">Kembali ke Halaman</a>
                </div>
            </form>
        </div>
    </div>
@endsection
