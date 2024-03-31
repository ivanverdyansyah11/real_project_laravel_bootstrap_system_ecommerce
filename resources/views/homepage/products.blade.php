@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <div class="wrapper d-flex flex-column flex-md-row justify-content-between align-items-end gap-3">
            <h2 class="title-product mb-3">Produk Kami</h2>
            @if ($request != null)
                <p class="text-mention">Kamu sedang mencari "{{ $request }}" dengan {{ count($products) }} produk
                    ditemukan!
                </p>
            @endif
        </div>
        @if (count($products) == 0)
            <div class="row">
                <div class="col-12 d-flex justify-content-center pt-5 pb-4">
                    <p class="text-mention">Tidak ada data produk!</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                @foreach ($products as $product)
                    @if ($product->stock > 0)
                        <div class="col">
                            <a href="{{ route('product', $product->id) }}" class="card card-reward mb-3">
                                <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                    class="card-img-top" height="200" style="object-fit: cover;">
                                <div class="card-body card-body-reward rounded">
                                    <h5 class="card-body-title mb-2">{{ $product->name }}</h5>
                                    <p class="card-body-text mb-3">{!! $product->description !!}</p>
                                    <button type="button" class="badge-primary">Rp.
                                        {{ number_format($product->selling_price, 2, ',', '.') }}/ botol</button>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
