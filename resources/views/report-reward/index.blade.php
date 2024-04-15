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
            <div class="wrapper-table">
                <table id="table_report" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Reseller</th>
                            <th>Nama Penghargaan</th>
                            <th>Poin Dibutuhkan</th>
                            <th>Tanggal Ditukarnya</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($transactions) == 0)
                            <tr>
                                <td>Data transaksi penghargaan reseller tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($transactions as $i => $transaction)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $transaction->reseller->name }}</td>
                                    <td>{{ $transaction->reward->name }}</td>
                                    <td>{{ $transaction->reward->points_required }}</td>
                                    <td>{{ Carbon\Carbon::parse($transaction->created_at)->format('l, d F Y') }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <a href="{{ route('report-reward.show', $transaction->id) }}"
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

    @push('js')
        <script>
            if (@json($transactions->count())) {
                $('#table_report').DataTable({
                    responsive: true
                });
            }
        </script>
    @endpush
@endsection
