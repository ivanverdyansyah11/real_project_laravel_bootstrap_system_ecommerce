@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
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
                        <h6 class="card-body-title mb-4">Rincian Pembelian</h6>
                        <div class="row">
                            @foreach ($carts as $cart)
                                <div class="col-12 d-flex gap-3 pt-3 pb-2">
                                    <img src="{{ file_exists('assets/images/product/' . $cart->product->image) && $cart->product->image ? asset('assets/images/product/' . $cart->product->image) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                                    <div class="wrapper d-flex justify-content-between align-items-center w-100">
                                        <div class="wrapper">
                                            <h6 class="card-body-subtitle mb-1">{{ $cart->product->name }}</h6>
                                            <p class="card-body-caption">Kategori Produk: {{ $cart->product->category->name }}</p>
                                        </div>
                                        <div class="wrapper text-end">
                                            <p class="card-body-caption mb-1">Harga Produk</p>
                                            <h6 class="card-body-subtitle mb-3">Rp. {{ number_format($cart->product->selling_price, 2, ",", ".") }}</h6>
                                            <div class="wrapper d-flex gap-2">
                                                <a href="{{ route('cart.edit', $cart->id) }}" class="button-primary">Transaksi Produk</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
