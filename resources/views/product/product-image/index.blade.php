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
            <button type="button" class="d-none d-md-inline-block button-primary mb-2" data-bs-toggle="modal"
                data-bs-target="#addModal">Tambah Gambar</button>
            <div class="wrapper-table">
                <table id="table_category" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar Produk</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($product_images) == 0)
                            <tr>
                                <td>Data gambar produk tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($product_images as $i => $product_image)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <img src="{{ file_exists('assets/images/product/' . $product_image->image) ? asset('assets/images/product/' . $product_image->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2 img-preview" width="100"
                                            height="100" style="object-fit: cover;">
                                    </td>
                                    <td>{{ $product_image->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <div class="wrapper d-flex gap-2 h-100">
                                            <button type="button"
                                                class="button-approved d-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal" data-bs-target="#thumbnailModal"
                                                data-id="{{ $product_image->id }}">
                                                <img src="{{ asset('assets/images/icons/approved.png') }}"
                                                    alt="Approved Icon" class="img-fluid" width="16">
                                            </button>
                                            <button type="button"
                                                class="button-delete d-none d-md-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="{{ $product_image->id }}">
                                                <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon"
                                                    class="img-fluid" width="16">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.product-image')
    @push('js')
        <script>
            $(document).on('click', '[data-bs-target="#thumbnailModal"]', function() {
                let id = $(this).data('id');
                $('#buttonEditProductImage').attr('action', '/product/thumbnail-image/' + id + '/edit');
            });

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteImage').attr('action', '/product/thumbnail-image/' + id + '/delete');
            });
        </script>
    @endpush
@endsection
