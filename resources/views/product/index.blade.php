@extends('layouts.main')

@section('content-dashboard')
    <div class="row row-cols-1 row-cols-lg-2 me-lg-4" style="margin-top: 32px;">
        <div class="col">
            <div class="dashboard-menu p-3">
                <div class="wrapper d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/dashboard/stock-product.png') }}" alt="Stock Product" class="img-fluid" width="32">
                    <p class="menu-title mb-0">Stok Produk</p>
                </div>
                <div class="row row-cols-3 child-menu">
                    @if ($product_limits->count() == 0)
                        <div class="col">
                            <p class="child-title">Tidak ada produk</p>
                            <p class="child-value">0</p>
                        </div>
                    @else
                        @foreach ($product_limits as $product)
                            <div class="col mb-2">
                                <p class="child-title">{{ $product->name }}</p>
                                <p class="child-value">{{ $product->stock }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col mt-4 mt-lg-0 pe-lg-0">
            <div class="dashboard-menu p-3">
                <div class="wrapper d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/dashboard/category.png') }}" alt="Stock Product" class="img-fluid" width="26">
                    <p class="menu-title mb-0">Kategori</p>
                </div>
                <div class="row row-cols-3 child-category">
                    @if ($product_limits->count() == 0)
                        <div class="col">
                            <div class="card-category p-3 rounded text-center">
                                <p class="category-title">Produk tidak ada</p>
                            </div>
                        </div>
                    @else
                        @foreach ($product_limits as $product)
                            <div class="col mb-2">
                                <div class="card-category p-3 rounded text-center">
                                    <p class="category-title">{{ $product->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row me-lg-4 mt-4">
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
            <a href="{{ route('product.create') }}" class="button-primary mb-2">Buat Produk</a>
            <div class="wrapper-table">
                <table id="table_product" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($products) == 0)
                            <tr>
                                <td>Data produk tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($products as $i => $product)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>Rp. {{ number_format($product->purchase_price, 2, ",", ".") }}</td>
                                    <td>Rp. {{ number_format($product->selling_price, 2, ",", ".") }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <a href="{{ route('product.show', $product->id) }}" class="button-detail d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                        </a>
                                        <a href="{{ route('product.edit', $product->id) }}" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-delete d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $product->id }}">
                                            <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon" class="img-fluid" width="16">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.product')
    @push('js')
        <script>
            $('#table_product').DataTable( {
                responsive: true
            } );

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteProduct').attr('action', '/product/' + id);
            });
        </script>
    @endpush
@endsection
