@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <h2 class="title-product mb-3">Produk Kami</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
            @foreach ($products as $product)
                @if ($product->stock > 0)
                    <div class="col">
                        <a href="{{ route('product', $product->id) }}" class="card card-reward mb-3">
                            <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product->image) : asset('assets/images/other/img-not-found.jpg') }}" class="card-img-top" height="200" style="object-fit: cover;">
                            <div class="card-body card-body-reward rounded">
                                <h5 class="card-body-title mb-2">{{ $product->name }}</h5>
                                <p class="card-body-text mb-3">{!! $product->description !!}</p>
                                <button type="button" class="badge-primary">Rp. {{ number_format($product->selling_price, 2, ",", ".") }}/ botol</button>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
