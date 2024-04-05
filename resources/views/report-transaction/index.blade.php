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
                <table id="table_report" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nomor Invois</th>
                            <th>Nama Reseller</th>
                            <th>Nama Produk</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($uniqueTransactions) == 0)
                            <tr>
                                <td>Data transaksi tidak ditemukan!</td>
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
                                    <td>Rp.
                                        {{ $transaction->total_per_product == null ? number_format($transaction->total_payment, 2, ',', '.') : number_format($transaction->total_per_product, 2, ',', '.') }}
                                    </td>
                                    <td class="wrapper d-flex gap-2">
                                        <a href="{{ route('transaction.show', $transaction->id) }}"
                                            class="button-detail d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon"
                                                class="img-fluid" width="16">
                                        </a>
                                        @if ($transaction->proof_of_payment == null)
                                            <a href="{{ route('transaction.edit', $transaction->id) }}"
                                                class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                                <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon"
                                                    class="img-fluid" width="16">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $('#table_report').DataTable({
                responsive: true
            });
        </script>
    @endpush
@endsection
