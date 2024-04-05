@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            <form class="row row-cols-1">
                <div class="col mb-3 d-flex flex-column">
                    <label for="image" class="form-label">Foto Produk</label>
                    <div class="scroll-image d-flex gap-2 " style="overflow-x: auto; width: fit-content;">
                        @foreach ($product_images as $product_image)
                            <div class="wrapper-image w-100">
                                <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product_image->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                    alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100"
                                    style="object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input readonly type="text" class="form-control" id="name" value="{{ $product->name }}">
                </div>
                <div class="col mb-3">
                    <label for="categories_id" class="form-label">Kategori</label>
                    <input readonly type="text" class="form-control" id="categories_id"
                        value="{{ $product->category->name }}">
                </div>
                <div class="col mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <input readonly type="text" class="form-control" id="unit" value="{{ $product->unit }}">
                </div>
                <div class="col mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input readonly type="number" class="form-control" id="stock" value="{{ $product->stock }}">
                </div>
                <div class="col mb-3">
                    <label for="purchase_price" class="form-label">Harga Beli</label>
                    <input readonly type="text" class="form-control" id="purchase_price"
                        value="Rp. {{ number_format($product->purchase_price, 2, ',', '.') }}">
                </div>
                <div class="col mb-3">
                    <label for="selling_price" class="form-label">Harga Jual</label>
                    <input readonly type="text" class="form-control" id="selling_price"
                        value="Rp. {{ number_format($product->selling_price, 2, ',', '.') }}">
                </div>
                <div class="col mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea readonly rows="4" class="form-control" id="description">{{ $product->description }}</textarea>
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <a href="{{ route('product.index') }}" class="button-dark">Kembali ke Halaman</a>
                </div>
            </form>
        </div>
    </div>
@endsection
