@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
        </div>
        <div class="col-12 pe-lg-0">
            <form class="row">
                <div class="col-12 mb-3 d-flex flex-column">
                    <label for="image" class="form-label">Foto Penghargaan</label>
                    <img src="{{ file_exists('assets/images/reward/' . $transaction->reward->image) && $transaction->reward->image ? asset('assets/images/reward/' . $transaction->reward->image) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="resellers_id" class="form-label">Nama Karyawan</label>
                    <input readonly type="text" class="form-control" id="resellers_id" value="{{ $transaction->reseller->name }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <input readonly type="text" class="form-control" id="gender" value="{{ $transaction->reseller->gender == 'L' ? 'Laki Laki' : 'Perempuan' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="number_phone" class="form-label">Nomor Telepon</label>
                    <input readonly type="text" class="form-control" id="number_phone" value="{{ $transaction->reseller->number_phone }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="rewards_id" class="form-label">Nama Penghargaan</label>
                    <input readonly type="text" class="form-control" id="rewards_id" value="{{ $transaction->reward->name }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="points_required" class="form-label">Poin Dibutuhkan</label>
                    <input readonly type="text" class="form-control" id="points_required" value="{{ $transaction->reward->points_required }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="created_at" class="form-label">Transaksi Dilakukan</label>
                    <input readonly type="text" class="form-control" id="created_at" value="{{ Carbon\Carbon::parse($transaction->created_at)->format('l, d F Y') }}">
                </div>
                <div class="col">
                    <button type="button" class="button-dark" onClick="history_back()">Kembali ke Halaman</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            function history_back() {
                window.history.back();
            }
        </script>
    @endpush
@endsection
