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
            <a href="{{ route('customer.create') }}" class="d-none d-md-inline-block button-primary mb-2">Buat Pelanggan</a>
            <div class="wrapper-table">
                <table id="table_customer" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor Handphone</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customers->count() == 0)
                            <tr>
                                <td>Data pelanggan tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($customers as $i => $customer)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->user->email }}</td>
                                    <td>{{ $customer->number_phone }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        @if ($customer->user->status == 0)
                                            <button type="button" class="button-approved d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#approveModal" data-id="{{ $customer->user->id }}">
                                                <img src="{{ asset('assets/images/icons/approved.png') }}" alt="Approved Icon" class="img-fluid" width="16">
                                            </button>
                                        @endif
                                        <a href="{{ route('customer.show', $customer->id) }}" class="button-detail d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                        </a>
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-delete d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $customer->id }}">
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

    @include('partials.customer')
    @push('js')
        <script>
            $('#table_customer').DataTable( {
                responsive: true
            } );

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteCustomer').attr('action', '/customer/' + id);
            });

            $(document).on('click', '[data-bs-target="#approveModal"]', function() {
                let id = $(this).data('id');
                $('#buttonApprovedCustomer').attr('action', '/customer/approved/' + id);
            });
        </script>
    @endpush
@endsection
