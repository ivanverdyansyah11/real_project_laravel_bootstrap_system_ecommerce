@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if (session()->has('failed'))
                <div class="alert alert-danger w-100 mb-3" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form class="row row-cols-1">
                <div class="col-12 mb-3">
                    <label for="shipping_price" class="form-label">Harga Pengiriman</label>
                    <input readonly type="text" class="form-control" id="shipping_price"
                        value="Rp. {{ number_format($shipping->shipping_price, 0, ',', '.') }}">
                </div>
                <div class="col-12 mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input readonly type="text" class="form-control" id="address" value="{{ $shipping->address }}">
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <a href="{{ route('shipping.index') }}" class="button-dark">Kembali ke Halaman</a>
                </div>
            </form>
        </div>
    </div>
@endsection
