@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-3" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form class="row row-cols-1" action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="col mb-3 d-flex flex-column">
                    <label for="image" class="form-label">Foto Produk</label>
                    <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product->image) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                    <input type="file" class="form-control input-file @error('image') is-invalid @enderror" name="image" id="image">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $product->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="categories_id" class="form-label">Kategori</label>
                    <select required class="form-control @error('categories_id') is-invalid @enderror" id="categories_id" name="categories_id">
                        @foreach ($categories as $category)
                            <option {{ $product->categories_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categories_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <select required class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit">
                        <option {{ $product->unit == 'pcs' ? 'selected' : '' }} value="pcs">Pcs</option>
                        <option {{ $product->unit == 'box' ? 'selected' : '' }} value="box">Box</option>
                    </select>
                    @error('unit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input required type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ $product->stock }}">
                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="purchase_price" class="form-label">Harga Beli</label>
                    <input required type="number" class="form-control @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" value="{{ $product->purchase_price }}">
                    @error('purchase_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="selling_price" class="form-label">Harga Jual</label>
                    <input required type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ $product->selling_price }}">
                    @error('selling_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea required rows="4" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $product->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <button type="submit" class="button-primary">Simpan Perubahan</button>
                    <a href="{{ route('product.index') }}" class="button-dark">Batal Edit</a>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });
        </script>
    @endpush
@endsection
