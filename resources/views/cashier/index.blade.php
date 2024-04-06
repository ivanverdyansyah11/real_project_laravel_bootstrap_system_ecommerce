@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if (session()->has('success'))
                <div class="alert alert-success w-100 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
        </div>
        <div class="col-12 pe-lg-0 mb-4">
            <form class="row" action="{{ route('cashier.store') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ rand() }}" name="invois">
                <input type="hidden" value="0" name="status">
                <div class="col-md-4 mb-3">
                    <label for="products_id" class="form-label">Nama Produk</label>
                    <select required class="form-control @error('products_id') is-invalid @enderror" id="products_id"
                        name="products_id">
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
                <div class="col-md-4 mb-3">
                    <label for="stock" class="form-label">Sisa Stock</label>
                    <input readonly type="number" class="form-control" id="stock" data-value="stock">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="price_per_unit" class="form-label">Harga Satuan</label>
                    <input required type="number" class="form-control" id="price_per_unit" data-value="price_per_unit"
                        name="selling_price">
                </div>
                <div class="col-md-6 mb-1">
                    <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                    <input required type="number" class="form-control @error('quantity') is-invalid @enderror"
                        id="quantity" name="quantity" value="{{ old('quantity') }}" min="1">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-1">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" class="form-control @error('total') is-invalid @enderror" id="total">
                </div>
                <div class="col-12 mb-3">
                    <p class="text-mention"></p>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="button-primary">Tambah ke Kasir</button>
                </div>
            </form>
        </div>
        <hr>
        <div class="col-12 mt-4">
            <div class="wrapper-table">
                <table id="table_category" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Barang</th>
                            <th>Total Harga</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($cashiers) == 0)
                            <tr>
                                <td>Data produk di kasir ini tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($cashiers as $i => $cashier)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $cashier->product->name }}</td>
                                    <td>{{ $cashier->selling_price }}</td>
                                    <td>{{ $cashier->quantity }}</td>
                                    <td>{{ $cashier->quantity * $cashier->selling_price }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <button type="button"
                                            class="button-delete d-none d-md-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="{{ $cashier->id }}">
                                            <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon"
                                                class="img-fluid" width="16">
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if (count($cashiers) != 0)
                <div class="d-flex justify-content-end">
                    <a href="{{ route('create-payment') }}" class="button-primary ">Lanjutkan Pembayaran</a>
                </div>
            @endif
        </div>
    </div>

    @include('partials.cashier')
    @push('js')
        <script>
            let productPrice;
            $(document).on('change', '#products_id', function() {
                let id = $(this).val();
                console.log(id);
                $.ajax({
                    type: 'get',
                    url: '/cashier/product/' + id,
                    success: function(product) {
                        if (product.status == 'success') {
                            $('[data-value="stock"]').val(product.data.stock);
                            $('[data-value="price_per_unit"]').val(product.data.selling_price);
                            productPrice = product.data.selling_price;
                        }
                    }
                });
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
                                console.log(package);
                                if (package.data != null) {
                                    $('#price_per_unit').val(package.data.selling_price);
                                    $('.text-mention').html('Kamu mendapatkan potongan sebesar Rp. ' +
                                        package.data.selling_price + ' karena membeli diatas ' + package
                                        .data.quantity + ' kuantitas produk');
                                } else {
                                    $('#price_per_unit').val(productPrice);
                                    $('.text-mention').html('');
                                }
                                $('#total').val(quantity * $('#price_per_unit').val());
                            }
                        }
                    });
                } else {
                    $('#price_per_unit').val(productPrice);
                    $('#total').val('');
                }
            });

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteCashier').attr('action', '/cashier/' + id);
            });
        </script>
    @endpush
@endsection
