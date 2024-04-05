@extends('layouts.main')

@section('content-dashboard')
    @php
        $uniqueTransactions = [];
        $invoiceTransactions = [];
        foreach ($transactions as $transaction) {
            if (!in_array($transaction->invois, $invoiceTransactions)) {
                $uniqueTransactions[] = $transaction;
                $invoiceTransactions[] = $transaction->invois;
            }
        }
    @endphp

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
            <div class="wrapper-table">
                <table id="table_transaction" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nomor Invois</th>
                            <th>Nama Reseller</th>
                            <th>Nama Produk</th>
                            <th>Pengiriman</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($uniqueTransactions) == 0)
                            <tr>
                                <td>Data transaksi menunggu pembayaran tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($uniqueTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->invois }}</td>
                                    <td>{{ $transaction->reseller ? $transaction->reseller->name : '-' }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td class="text-capitalize ">{{ $transaction->shipping }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        @if ($transaction->shipping == 'ekspedisi' && $transaction->shipping_price == null)
                                            <button type="button"
                                                class="button-approved d-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal" data-bs-target="#approveModal"
                                                data-id="{{ $transaction->id }}">
                                                <img src="{{ asset('assets/images/icons/approved.png') }}"
                                                    alt="Approved Icon" class="img-fluid" width="16">
                                            </button>
                                        @endif
                                        <a href="{{ route('transaction.show', $transaction->id) }}"
                                            class="button-detail d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon"
                                                class="img-fluid" width="16">
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

    @include('partials.transaction-payment')
    @push('js')
        <script>
            $('#table_transaction').DataTable({
                responsive: true
            });

            $(document).on('click', '[data-bs-target="#approveModal"]', function() {
                let id = $(this).data('id');
                $('#buttonApprovedShipping').attr('action', '/transaction/approvedShipping/' + id);
            });
        </script>
    @endpush
@endsection
