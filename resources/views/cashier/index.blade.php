@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block w-100 " style="margin-top: 32px;">
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
            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteCashier').attr('action', '/cashier/' + id);
            });
        </script>
    @endpush
@endsection
