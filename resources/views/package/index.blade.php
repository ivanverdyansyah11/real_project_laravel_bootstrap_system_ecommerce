@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4" style="margin-top: 32px;">
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
            <button type="button" class="d-none d-md-inline-block button-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">Buat Paket</button>
            <div class="wrapper-table">
                <table id="table_package" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Nama Paket</th>
                            <th>Kuantitas</th>
                            <th>Harga Per Botol</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($packages->count() == 0)
                            <tr>
                                <td>Data paket tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($packages as $i => $package)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $package->product->name }}</td>
                                    <td>{{ $package->name ?: '-' }}</td>
                                    <td>{{ $package->quantity }}</td>
                                    <td>Rp. {{ number_format($package->selling_price, 2, ",", ".") }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <button type="button" class="button-detail d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $package->id }}">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-edit d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $package->id }}">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-delete d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $package->id }}">
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

    @include('partials.package')
    @push('js')
        <script>
            $('#table_package').DataTable( {
                responsive: true
            } );

            $(document).on('click', '[data-bs-target="#detailModal"]', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: '/package/' + id,
                    success: function(package) {
                        if (package.status == 'success') {
                            $('[data-value="products_id"]').val(package.data.product.name);
                            $('[data-value="name"]').val(package.data.name ? package.data.name : '-');
                            $('[data-value="quantity"]').val(package.data.quantity);
                            $('[data-value="selling_price"]').val(package.data.selling_price);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#editModal"]', function() {
                let id = $(this).data('id');
                $('[data-element="row-edit-select"] option').remove();
                $('#buttonEditPackage').attr('action', '/package/' + id);
                $.ajax({
                    type: 'get',
                    url: '/package/' + id,
                    success: function(package) {
                        if (package.status == 'success') {
                            package.products.forEach(products => {
                                if (products.id === package.data.products_id) {
                                    $('[data-element="row-edit-select"]').append(
                                        `<option value="${products.id}" selected>${products.name}</option>`
                                    );
                                } else {
                                    $('[data-element="row-edit-select"]').append(
                                        `<option value="${products.id}">${products.name}</option>`
                                    );
                                }
                            });
                            $('[data-value="name"]').val(package.data.name);
                            $('[data-value="quantity"]').val(package.data.quantity);
                            $('[data-value="selling_price"]').val(package.data.selling_price);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeletePackage').attr('action', '/package/' + id);
            });
        </script>
    @endpush
@endsection
