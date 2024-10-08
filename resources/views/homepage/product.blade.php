@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-4">
                <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                    class="card-img-top img-fluid rounded thumbnail-img" style="aspect-ratio: 1/1; object-fit: cover;">
                <div class="scroll-image mt-3" style="overflow: auto; width: 100%;">
                    <div class="wrapper d-flex gap-2" style="width: fit-content;">
                        @foreach ($product_images as $product_image)
                            <img src="{{ file_exists('assets/images/product/' . $product_image->image) ? asset('assets/images/product/' . $product_image->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                class="rounded product-img {{ $product->image == $product_image->image ? 'opacity-100' : 'opacity-50' }}"
                                alt="Product Image" width="100" height="100"
                                style="object-fit: cover; cursor: pointer;" onclick="changeThumbnailImage(this)">
                        @endforeach
                    </div>
                </div>
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

    @push('js')
        <script>
            const productImg = document.querySelectorAll('.product-img')
            const thumbnailImg = document.querySelector('.thumbnail-img')

            function changeThumbnailImage(element) {
                productImg.forEach(image => {
                    image.classList.remove('opacity-100')
                    image.classList.add('opacity-50')
                });
                thumbnailImg.setAttribute('src', element.getAttribute('src'))
                element.classList.remove('opacity-50')
                element.classList.add('opacity-100')
            }
        </script>
    @endpush
@endsection
