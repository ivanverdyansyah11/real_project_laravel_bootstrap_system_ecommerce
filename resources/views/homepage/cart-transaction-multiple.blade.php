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
                <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="w-100" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
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
                            <h6 class="card-body-title mb-4">Pembayaran Transaksi</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customers_id" class="form-label">Nama Pelanggan</label>
                                    @if (auth()->user()->role == 'customer')
                                        <input required type="hidden" class="form-control @error('customers_id') is-invalid @enderror" id="customers_id" name="customers_id" value="{{ $customer->id }}">
                                        <input readonly type="text" class="form-control" value="{{ $customer->name }}">
                                    @else
                                        @if (auth()->user()->role == 'reseller')
                                            <input type="hidden" name="resellers_id" value="{{ auth()->user()->id }}">
                                        @endif
                                        <select required class="form-control @error('customers_id') is-invalid @enderror" id="customers_id" name="customers_id">
                                            <option value="">Pilih pelanggan</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('customers_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                                    <div class="col-md-6 mb-3">
                                        <label for="resellers_id" class="form-label">Nama Karyawan</label>
                                        <select required class="form-control @error('resellers_id') is-invalid @enderror" id="resellers_id" name="resellers_id">
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
                                <div class="col-md-6 mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input required type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total', $cart->product->selling_price) }}">
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
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Upload Bukti Pembayaran</h6>
                            <div class="row">
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
                                <div class="wrapper d-flex gap-2">
                                    <button type="submit" class="button-primary">Tambah Karyawan</button>
                                    <a href="{{ route('cart.index') }}" class="button-dark">Batal Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });

            let productPrice = $('#selling_price').val();
            function handleTransaction() {
                let quantity = $('#quantity').val();
                let productsId = $('#products_id').val();
                if (quantity != '') {
                    $.ajax({
                        type: 'get',
                        url: '/transaction/get_package/' + quantity + '/' + productsId,
                        success: function(package) {
                            if (package.status == 'success') {
                                if (package.data != null) {
                                    $('#selling_price').val(package.data.selling_price);
                                    $('.text-mention').html('Kamu mendapatkan potongan sebesar Rp. ' + package.data.selling_price + ' karena membeli diatas ' + package.data.quantity + ' kuantitas produk');
                                } else {
                                    $('#selling_price').val(productPrice);
                                    $('.text-mention').html('');
                                }
                                $('#total').val(quantity * $('#selling_price').val());
                            }
                        }
                    });
                } else {
                    $('#selling_price').val(productPrice);
                    $('#total').val('');
                }
            }

            $(document).ready(function() {
                $('#total').val(parseInt($('#quantity').val()) * parseInt(productPrice));
                handleTransaction();
            });

            $(document).on('change', '#quantity', function() {
                handleTransaction();
            });
        </script>
    @endpush
@endsection
