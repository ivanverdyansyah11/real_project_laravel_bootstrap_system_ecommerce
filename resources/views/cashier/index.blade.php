@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
        </div>
        <div class="col-12 pe-lg-0">
            <form class="row" action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="1" name="status">
                <div class="col-12 mb-3 d-flex flex-column">
                    <label for="proof_of_payment" class="form-label">Foto Bukti Pembayaran</label>
                    <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                    <input type="file" class="form-control input-file @error('proof_of_payment') is-invalid @enderror" name="proof_of_payment" id="proof_of_payment">
                    @error('proof_of_payment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- <div class="col-md-6 mb-3">
                    <label for="customers_id" class="form-label">Nama Pelanggan</label>
                    <select required class="form-control @error('customers_id') is-invalid @enderror" id="customers_id" name="customers_id">
                        <option value="">Pilih pelanggan</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customers_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div> --}}
                <div class="col-md-6 mb-3">
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
                <div class="col-md-6 mb-3">
                    <label for="products_id" class="form-label">Nama Produk</label>
                    <select required class="form-control @error('products_id') is-invalid @enderror" id="products_id" name="products_id">
                        <option value="">Pilih produk</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('products_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Sisa Stock</label>
                    <input readonly type="number" class="form-control" id="stock" data-value="stock">
                </div>
                <div class="col-12">
                    <p class="text-mention"></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                    <input required type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price_per_unit" class="form-label">Harga Satuan</label>
                    <input readonly type="number" class="form-control" id="price_per_unit" data-value="price_per_unit">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input required type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total') }}" readonly>
                    @error('total')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="total_payment" class="form-label">Total Bayar</label>
                    <input required type="number" class="form-control @error('total_payment') is-invalid @enderror" id="total_payment" name="total_payment" value="{{ old('total_payment') }}">
                    @error('total_payment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <button type="submit" class="button-primary">Tambah Transaksi</button>
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

            let productPrice;
            $(document).on('change', '#products_id', function() {
                let id = $(this).val();
                $('#total').val('');
                if (id != '') {
                    $.ajax({
                        type: 'get',
                        url: '/transaction/get_product/' + id,
                        success: function(product) {
                            if (product.status == 'success') {
                                $('#stock').val(product.data.stock);
                                $('#price_per_unit').val(product.data.selling_price);
                                productPrice = product.data.selling_price;
                                if (product.data.stock == 0) {
                                    $('.text-mention').html('Stok pada produk ini telah habis!');
                                    $('#quantity').val('');
                                    $('#quantity').attr('readonly', 'readonly');
                                } else {
                                    $('.text-mention').html('');
                                    $('#quantity').removeAttr('readonly', 'readonly');
                                    $('#quantity').attr('max', product.data.stock);
                                }
                            }
                        }
                    });
                } else {
                    $('#stock').val('');
                    $('#price_per_unit').val('');
                    $('#quantity').val('');
                }
            });

            $(document).on('change', '#quantity', function() {
                let quantity = $(this).val();
                let productsId = $('#products_id').val();
                if (quantity != '') {
                    $.ajax({
                        type: 'get',
                        url: '/transaction/get_package/' + quantity + '/' + productsId,
                        success: function(package) {
                            if (package.status == 'success') {
                                if (package.data != null) {
                                    $('#price_per_unit').val(package.data.selling_price);
                                    $('.text-mention').html('Kamu mendapatkan potongan sebesar Rp. ' + package.data.selling_price + ' karena membeli diatas ' + package.data.quantity + ' kuantitas produk');
                                } else {
                                    $('#price_per_unit').val(productPrice);
                                    $('.text-mention').html('');
                                }
                                $('#total').val(quantity * $('#price_per_unit').val());
                            }
                        }
                    });
                } else {
                    $('#total').val('');
                }
            });
        </script>
    @endpush
@endsection
