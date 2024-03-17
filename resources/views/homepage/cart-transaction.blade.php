@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <div class="row" style="margin-top: 32px;">
            <div class="col-12">
                @if (session()->has('success'))
                    <div class="alert alert-success w-100 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif(session()->has('failed'))
                    <div class="alert alert-danger w-100 mb-4" role="alert">
                        {{ session('failed') }}
                    </div>
                @endif
                <form action="{{ route('transaction-store-product', $cart->id) }}" method="POST" class="w-100" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="hidden" value="{{ rand() }}" name="invois">
                    <input type="hidden" value="{{ $cart->id }}" id="cart_id">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Ringkasan Produk</h6>
                            <div class="row">
                                <div class="col-12 mb-3 d-flex flex-column">
                                    <label class="form-label">Foto Produk</label>
                                    <img src="{{ file_exists('assets/images/product/' . $cart->product->image) && $cart->product->image ? asset('assets/images/product/' . $cart->product->image) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2" width="100" height="100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="product_name" class="form-label">Nama Produk</label>
                                    <input readonly type="hidden" class="form-control" id="products_id" name="products_id" value="{{ $cart->product->id }}">
                                    <input readonly type="text" class="form-control" id="product_name" value="{{ $cart->product->name }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label">Sisa Stok</label>
                                    <input readonly type="text" class="form-control" id="stock" value="{{ $cart->product->stock }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="purchase_price" class="form-label">Harga Beli</label>
                                    <input readonly type="text" class="form-control" id="purchase_price" value="{{ $cart->product->purchase_price }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="selling_price" class="form-label">Harga Jual</label>
                                    <input readonly type="text" class="form-control" id="selling_price" value="{{ $cart->product->selling_price }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                                    <input required type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}">
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <p class="text-mention"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Data Pembeli</h6>
                            <div class="row">
                                @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                                    <div class="col-12 mb-3">
                                        <label for="resellers_id" class="form-label">Nama Karyawan</label>
                                        <select class="form-control @error('resellers_id') is-invalid @enderror" id="resellers_id" name="resellers_id">
                                            <option value="">Pilih karyawan</option>
                                            @foreach ($resellers as $reseller)
                                                <option value="{{ $reseller->id }}">{{ $reseller->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('resellers_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="wrapper d-flex gap-2">
                                        <button type="submit" class="button-primary">Lanjutkan Pembayaran</button>
                                        <a href="{{ route('cart.index') }}" class="button-dark">Batal Lanjutkan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
