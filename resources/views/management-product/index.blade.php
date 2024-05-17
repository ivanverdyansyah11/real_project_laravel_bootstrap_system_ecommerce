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
            <form class="row row-cols-1 mb-4" action="{{ route('management-product.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="col mb-3">
                    <label for="products_id" class="form-label">Nama Produk</label>
                    <select required class="form-control @error('products_id') is-invalid @enderror" id="products_id"
                        name="products_id">
                        <option value="">Pilih nama produk</option>
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
                <div class="col mb-3">
                    <label for="type" class="form-label">Tipe</label>
                    <select required class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="">Pilih tipe restok</option>
                        <option value="add">Menambahkan</option>
                        <option value="subtract">Mengurangi</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="quantity" class="form-label">Kuantitas</label>
                    <input required type="number" class="form-control @error('quantity') is-invalid @enderror"
                        id="quantity" name="quantity" value="{{ old('quantity') }}">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <button type="submit" class="button-primary">Restock Produk</button>
                    <button type="reset" class="button-dark">Bersihkan Form</button>
                </div>
            </form>
            <div class="wrapper-table">
                <table id="table_management_product" class="table display responsive nowrap table-striped"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Kuantitas</th>
                            <th>Tipe Restock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($management_products) == 0)
                            <tr>
                                <td>Data restock barang tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($management_products as $i => $management_product)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $management_product->product->name }}</td>
                                    <td>{{ $management_product->quantity }}</td>
                                    @if ($management_product->type == 'add')
                                        <td>Menambahkan stok produk</td>
                                    @elseif($management_product->type == 'subtract')
                                        <td>Mengurangi stok produk</td>
                                    @elseif($management_product->type == 'purchased')
                                        <td>Produk dibeli</td>
                                    @endif
                                    <td class="wrapper d-flex gap-2">
                                        <button type="button"
                                            class="button-edit d-none d-md-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="{{ $management_product->id }}">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon"
                                                class="img-fluid" width="16">
                                        </button>
                                        <button type="button"
                                            class="button-delete d-none d-md-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="{{ $management_product->id }}">
                                            <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon"
                                                class="img-fluid" width="16">
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.management-product')
    @push('js')
        <script>
            $('#table_management_product').DataTable({
                responsive: true
            });

            $(document).on('click', '[data-bs-target="#editModal"]', function() {
                let id = $(this).data('id');
                $('#buttonEditManagementProduct').attr('action', '/management-product/' + id);
                $.ajax({
                    type: 'get',
                    url: '/management-product/' + id,
                    success: function(managementProduct) {
                        if (managementProduct.status == 'success') {
                            $('[data-value="products_id"]').val(managementProduct.data.products_id);
                            $('[data-value="quantity"]').val(managementProduct.data.quantity);
                            $('[data-value="quantity"]').attr('min', managementProduct.data.quantity);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteManagementProduct').attr('action', '/management-product/' + id);
            });
        </script>
    @endpush
@endsection
