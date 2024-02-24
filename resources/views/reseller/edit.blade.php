@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            <form class="row row-cols-1">
                <div class="col mb-3">
                    <label for="photo_ktp" class="form-label">Photo KTP</label>
                    <input type="text" class="form-control" id="photo_ktp" name="photo_ktp">
                </div>
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="col mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="col mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="col mb-3">
                    <label for="number_phone" class="form-label">Number Phone</label>
                    <input type="number" class="form-control" id="number_phone">
                </div>
                <div class="col d-flex gap-2">
                    <button type="button" class="button-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection