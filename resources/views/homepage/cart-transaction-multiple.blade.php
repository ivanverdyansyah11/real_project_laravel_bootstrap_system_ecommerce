@extends('layouts.main')

@section('content-homepage')
    @php
        $cartId = [];
        $productSelectId = [];
        foreach ($cart as $item) {
            $cartId[] = $item->id;
            $productSelectId[] = $item->product->id;
        }
        $cartId = implode('+', $cartId);
        $productSelectId = implode('+', $productSelectId);
    @endphp
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
                <form action="{{ route('transaction-store-product', $cartId) }}" method="POST" class="w-100"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{ rand() }}" name="invois">
                    @foreach ($cart as $i => $item)
                        <input type="hidden" value="{{ $item->id }}" id="cart_id">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-body-title mb-4">Ringkasan Produk</h6>
                                <div class="row">
                                    <div class="col-12 mb-3 d-flex flex-column">
                                        <label class="form-label">Foto Produk</label>
                                        <img src="{{ file_exists('assets/images/product/' . $item->product->image) && $item->product->image ? asset('assets/images/product/' . $item->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2" width="100" height="100"
                                            style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="product_name" class="form-label">Nama Produk</label>
                                        <input readonly type="hidden" class="form-control"
                                            id="products_id{{ $i }}" name="products_id[]"
                                            value="{{ $item->product->id }}">
                                        <input readonly type="text" class="form-control" id="product_name"
                                            value="{{ $item->product->name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="stock" class="form-label">Nama Paket</label>
                                        @php
                                            $packageName = '-';
                                            if (count($package) != 0) {
                                                foreach ($package as $pack) {
                                                    if ($pack->products_id == $item->product->id) {
                                                        $packageName = $pack->name;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <input readonly type="text" class="form-control" id="stock"
                                            value="{{ $packageName }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        @php
                                            $packagePrice = $item->product->selling_price;
                                            if (count($package) != 0) {
                                                foreach ($package as $pack) {
                                                    if ($pack->products_id == $item->product->id) {
                                                        $packagePrice = $pack->selling_price;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <input type="hidden" id="selling_price_product"
                                            value="{{ $item->product->selling_price }}">
                                        <label for="selling_price" class="form-label">Harga/botol</label>
                                        <input readonly type="text" class="form-control"
                                            id="selling_price{{ $i }}" value="{{ $packagePrice }}"
                                            name="price_per_product[]">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="total" class="form-label">Total</label>
                                        <input readonly type="text" class="form-control" id="total{{ $i }}"
                                            value="{{ $item->quantity * $packagePrice }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                                        <input required type="number"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            id="quantity{{ $i }}" name="quantity[]"
                                            value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->product->stock }}">
                                        @error('quantity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <p class="text-mention{{ $i }}">
                                            @if (count($package) != 0)
                                                @foreach ($package as $pack)
                                                    @if ($pack->products_id == $item->product->id)
                                                        Kamu mendapatkan potongan sebesar Rp.
                                                        {{ $pack->selling_price }} karena membeli diatas
                                                        {{ $pack->quantity }}
                                                        kuantitas produk
                                                    @endif
                                                @endforeach
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-body-title mb-4">Data Reseller</h6>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="resellers_id" class="form-label">Nama Reseller</label>
                                        <select class="form-control @error('resellers_id') is-invalid @enderror"
                                            id="resellers_id" name="resellers_id">
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
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Data Pengiriman</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="shipping" class="form-label">Pengiriman Barang</label>
                                    <select required class="form-control @error('shipping') is-invalid @enderror"
                                        id="shipping" name="shipping">
                                        <option value="">Pilih Pengiriman</option>
                                        <option value="ekspedisi">Ekspedisi</option>
                                        <option value="offline">Ambil ke Kantor Dewantari</option>
                                    </select>
                                    @error('shipping')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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

    @push('js')
        <script>
            const productPrice = document.querySelectorAll('#selling_price_product')
            let index = 0
            productPrice.forEach((product, index) => {
                $(document).on('change', `#quantity${index}`, function() {
                    let quantity = $(this).val();
                    let productsId = $(`#products_id` + index).val()
                    if (quantity != '') {
                        $.ajax({
                            type: 'get',
                            url: '/transaction/get_package/' + quantity + '/' + productsId,
                            success: function(package) {
                                if (package.status == 'success') {
                                    if (package.data != null) {
                                        $(`#selling_price${index}`).val(package.data.selling_price);
                                        $(`.text-mention${index}`).html(
                                            'Kamu mendapatkan potongan sebesar Rp. ' +
                                            package.data.selling_price +
                                            ' karena membeli diatas ' + package
                                            .data.quantity + ' kuantitas produk');
                                    } else {
                                        $(`#selling_price${index}`).val(product.getAttribute(
                                            'value'));
                                        $(`.text-mention${index}`).html('');
                                    }
                                    $(`#total${index}`).val(quantity * $(`#selling_price${index}`)
                                        .val());
                                }
                            }
                        });
                    } else {
                        $(`#selling_price${index}`).val(product.getAttribute('value'));
                        $(`#total${index}`).val('');
                    }
                });
            })
        </script>
    @endpush
@endsection
