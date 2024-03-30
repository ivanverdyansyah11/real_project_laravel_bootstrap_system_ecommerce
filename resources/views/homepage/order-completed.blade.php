@extends('layouts.main')

@section('content-homepage')
    <div class="row justify-content-center order-completed text-center mt-4">
        <div class="col-10 col-md-8 col-lg-6 col-xl-5">
            <img src="{{ asset('assets/images/other/order-completed.svg') }}" alt="Order Completed Image" class="img-fluid">
            <h2 class="title">Pesanan Sedang Diproses!</h2>
            <p class="description">Cek menu notifikasi secara berkala untuk informasi pemesanan!</p>
            <div class="button-group">
                <a href="{{ route('cart.index') }}" class="button-primary">Kembali ke Keranjang</a>
            </div>
        </div>
    </div>
@endsection
