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
            <button type="button" class="d-none d-md-inline-block button-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">Buat Kategori</button>
            <div class="wrapper-table">
                <table id="table_category" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($categories->count() == 0)
                            <tr>
                                <td>Data kategori tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($categories as $i => $category)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <button type="button" class="button-detail d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $category->id }}">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-edit d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $category->id }}">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-delete d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $category->id }}">
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

    @include('partials.category')
    @push('js')
        <script>
            $('#table_category').DataTable( {
                responsive: true
            } );

            $(document).on('click', '[data-bs-target="#detailModal"]', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: '/category/' + id,
                    success: function(category) {
                        if (category.status == 'success') {
                            $('[data-value="name"]').val(category.data.name);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#editModal"]', function() {
                let id = $(this).data('id');
                $('#buttonEditCategory').attr('action', '/category/' + id);
                $.ajax({
                    type: 'get',
                    url: '/category/' + id,
                    success: function(category) {
                        if (category.status == 'success') {
                            $('[data-value="name"]').val(category.data.name);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteCategory').attr('action', '/category/' + id);
            });
        </script>
    @endpush
@endsection
