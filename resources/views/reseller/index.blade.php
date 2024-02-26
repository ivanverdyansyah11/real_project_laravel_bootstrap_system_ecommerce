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
            <a href="{{ route('reseller.create') }}" class="d-none d-md-inline-block button-primary mb-2">Buat Karyawan</a>
            <div class="wrapper-table">
                <table id="table_reseller" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor Handphone</th>
                            <th>Poin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($resellers->count() == 0)
                            <tr>
                                <td colspan="6">Data karyawan tidak ditemukan!</td>
                            </tr>
                        @else
                            @foreach ($resellers as $reseller)
                                <tr>
                                    <td>{{ $reseller->id }}</td>
                                    <td>{{ $reseller->name }}</td>
                                    <td>{{ $reseller->user->email }}</td>
                                    <td>{{ $reseller->number_phone }}</td>
                                    <td>{{ $reseller->poin }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <a href="{{ route('reseller.show', $reseller->id) }}" class="button-detail d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                        </a>
                                        <a href="{{ route('reseller.edit', $reseller->id) }}" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-delete d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $reseller->id }}">
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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Modal Hapus Karyawan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="buttonDeleteReseller" method="POST" class="d-inline-block w-100">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        <p>Apakah kamu yakin untuk menghapus karyawan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel Delete</button>
                        <button type="submit" class="btn btn-primary">Hapus Karyawan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $('#table_reseller').DataTable( {
                responsive: true
            } );

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteReseller').attr('action', '/reseller/' + id);
            });
        </script>
    @endpush
@endsection
