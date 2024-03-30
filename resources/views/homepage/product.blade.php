@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-4">
                <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                    class="card-img-top img-fluid rounded">
            </div>
            <div class="col-6">
                <div class="wrapper d-flex align-items-center justify-content-between mb-3">
                    <h5 class="title-product">{{ $product->name }}</h5>
                    <h6 class="title-price mt-3">Rp. {{ number_format($product->selling_price, 2, ',', '.') }}
                    </h6>
                </div>
                <p class="badge-primary">{{ $product->category->name }}</p>
                <p class="paragraph-title mt-3">Deskripsi Produk</p>
                <p class="paragraph mt-1">{!! $product->description !!}</p>
                <div class="wrapper mt-4 d-flex gap-2">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="users_id"
                            value="{{ auth()->user() != null ? auth()->user()->id : '' }}">
                        <input type="hidden" name="products_id" value="{{ $product->id }}">
                        <button type="button" class="button-primary" data-bs-toggle="modal"
                            data-bs-target="#quantityModal">Tambah Keranjang</button>
                        @include('partials.quantity-cart')
                    </form>
                    <form action="{{ route('create-session') }}" method="POST">
                        @csrf
                        <input type="hidden" name="users_id"
                            value="{{ auth()->user() != null ? auth()->user()->id : '' }}">
                        <input type="hidden" name="products_id" value="{{ $product->id }}">
                        <button type="button" class="button-primary" data-bs-toggle="modal"
                            data-bs-target="#quantityTransactionModal">Beli Sekarang</button>
                        @include('partials.quantity-cart-transaction')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
