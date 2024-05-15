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
                <table id="table_reseller" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Alamat</th>
                            <th>Harga Pengiriman</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $shipping->address }}</td>
                            <td>Rp. {{ number_format($shipping->shipping_price, 0, ',', '.') }}</td>
                            <td class="wrapper d-flex gap-2">
                                <a href="{{ route('shipping.show') }}"
                                    class="button-detail d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon"
                                        class="img-fluid" width="16">
                                </a>
                                <a href="{{ route('shipping.edit') }}"
                                    class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid"
                                        width="16">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
