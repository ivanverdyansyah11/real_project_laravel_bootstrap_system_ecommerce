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
                <form action="{{ route('transaction-store-product', $cart->id) }}" method="POST" class="w-100"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{ rand() }}" name="invois">
                    <input type="hidden" value="{{ $cart->id }}" id="cart_id">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Ringkasan Produk</h6>
                            <div class="row">
                                <div class="col-12 mb-3 d-flex flex-column">
                                    <label class="form-label">Foto Produk</label>
                                    <img src="{{ file_exists('assets/images/product/' . $cart->product->image) && $cart->product->image ? asset('assets/images/product/' . $cart->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                        alt="Image Not Found" class="rounded mb-2" width="100" height="100"
                                        style="object-fit: cover;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="product_name" class="form-label">Nama Produk</label>
                                    <input readonly type="hidden" class="form-control" id="products_id" name="products_id"
                                        value="{{ $cart->product->id }}">
                                    <input readonly type="text" class="form-control" id="product_name"
                                        value="{{ $cart->product->name }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="package_name" class="form-label">Nama Paket</label>
                                    <input readonly type="text" class="form-control" id="package_name"
                                        value="{{ $package != null ? $package->name : '-' }}">
                                </div>
                                @php
                                    $totalProduct;
                                    if ($package != null) {
                                        $totalProduct = $package->selling_price;
                                    } else {
                                        $totalProduct = $cart->product->selling_price;
                                    }
                                @endphp
                                <div class="col-md-6 mb-3">
                                    <input type="hidden" id="selling_price_product"
                                        value="{{ $cart->product->selling_price }}">
                                    <label for="selling_price" class="form-label">Harga/botol</label>
                                    <input readonly type="text" class="form-control" id="selling_price"
                                        value="{{ $package != null ? $package->selling_price : $cart->product->selling_price }}"
                                        name="price_per_product">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input readonly type="text" class="form-control" id="total"
                                        value="{{ $cart->quantity * $totalProduct }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                                    <input required type="number"
                                        class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                        name="quantity" value="{{ $cart->quantity }}" min="1"
                                        max="{{ $cart->product->stock }}">
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <p class="text-mention">
                                        @if ($package != null)
                                            Kamu mendapatkan potongan sebesar Rp.
                                            {{ $package->selling_price }} karena membeli diatas {{ $package->quantity }}
                                            kuantitas produk
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                        <div class="card mt-4">
                            <div class="card-body">
                                <h6 class="card-body-title mb-4">Data Reseller</h6>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="resellers_id" class="form-label">Nama Reseller</label>
                                        <select class="form-control @error('resellers_id') is-invalid @enderror"
                                            id="resellers_id" name="resellers_id">
                                            <option value="">Pilih reseller</option>
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
                                <div class="col-12 mb-3" id="formMap">
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                </div>
                                <div class="col-12 mb-3 d-none" id="formAddress">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input required type="text"
                                        class="form-control @error('address') is-invalid @enderror" id="address"
                                        name="address" readonly required>
                                    @error('address')
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
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            $(document).on('change', '#shipping', function() {
                if ($('#shipping').val() == 'ekspedisi') {
                    $('#formAddress').removeClass('d-none')
                    $('#address').prop('required', true);
                } else {
                    $('#formAddress').addClass('d-none')
                    $('#address').prop('required', false);
                }
            })

            function getAddressFromLatLng(latitude, longitude) {
                let url =
                    `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyADJk8ffwFqsJC3hlxAgv-p2uaEeY47HAc`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'OK') {
                            let address = data.results[0].formatted_address;
                            $('#address').val(address);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            let map = L.map('map').setView([-8.630072702457348, 115.20958478281852], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            function onMapClick(e) {
                $('#longitude').val(e.latlng.lat);
                $('#latitude').val(e.latlng.lng);
                getAddressFromLatLng(e.latlng.lat, e.latlng.lng)
            }
            map.on('click', onMapClick);

            let productPrice = $('#selling_price_product').val();
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
                                    $('#package_name').val(package.data.name);
                                    $('#selling_price').val(package.data.selling_price);
                                    $('.text-mention').html('Kamu mendapatkan potongan sebesar Rp. ' +
                                        package.data.selling_price + ' karena membeli diatas ' + package
                                        .data.quantity + ' kuantitas produk');
                                } else {
                                    $('#package_name').val('-');
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
            });

            let sellingPrice = document.getElementById('selling_price')
            sellingPrice.value = formatRupiah(sellingPrice.value, 'Rp. ');
            let total = document.getElementById('total')
            total.value = formatRupiah(total.value, 'Rp. ');

            function formatRupiah(angka, prefix)
            {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split    = number_string.split(','),
                    sisa     = split[0].length % 3,
                    rupiah     = split[0].substr(0, sisa),
                    ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        </script>
    @endpush
@endsection
