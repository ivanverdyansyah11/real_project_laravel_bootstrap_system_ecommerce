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
                            <th>Nama Product</th>
                            <th>Stok Saat Ini</th>
                            <th>Pesan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($report_products) == 0)
                            <tr>
                                <td>Data laporan produk tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($report_products as $report_product)
                                <tr>
                                    <td>{{ $report_product->product->name }}</td>
                                    <td>{{ $report_product->stock }}</td>
                                    @if ($report_product->status == 4)
                                        <td>Produk {{ $report_product->product->name }} baru ditambahkan</td>
                                    @elseif($report_product->status == 3)
                                        <td>Produk {{ $report_product->product->name }} stok baru ditambahkan</td>
                                    @elseif($report_product->status == 2)
                                        <td>Produk {{ $report_product->product->name }} stok baru dikurangkan</td>
                                    @elseif($report_product->status == 1)
                                        <td>Produk {{ $report_product->product->name }} stoknya habis</td>
                                    @endif
                                    <td class="wrapper d-flex gap-2">
                                        <a href="#"
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
            $('#table_report').DataTable({
                responsive: true
            });
        </script>
    @endpush
@endsection
