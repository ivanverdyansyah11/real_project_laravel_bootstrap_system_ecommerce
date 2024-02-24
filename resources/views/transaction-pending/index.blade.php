@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            <div class="wrapper-table">
                <table id="table_transaction" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nomor Invoice</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>75647656756</td>
                            <td>System Architect</td>
                            <td>Pending</td>
                            <td>Rp. 500.000</td>
                            <td class="wrapper d-flex gap-2">
                                <a href="#" class="button-approved d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/approved.png') }}" alt="Approved Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-detail d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-delete d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon" class="img-fluid" width="16">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>75647656756</td>
                            <td>System Architect</td>
                            <td>Pending</td>
                            <td>Rp. 500.000</td>
                            <td class="wrapper d-flex gap-2">
                                <a href="#" class="button-approved d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/approved.png') }}" alt="Approved Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-detail d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-delete d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon" class="img-fluid" width="16">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>75647656756</td>
                            <td>System Architect</td>
                            <td>Pending</td>
                            <td>Rp. 500.000</td>
                            <td class="wrapper d-flex gap-2">
                                <a href="#" class="button-approved d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/approved.png') }}" alt="Approved Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-detail d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-delete d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon" class="img-fluid" width="16">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>75647656756</td>
                            <td>System Architect</td>
                            <td>Pending</td>
                            <td>Rp. 500.000</td>
                            <td class="wrapper d-flex gap-2">
                                <a href="#" class="button-approved d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/approved.png') }}" alt="Approved Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-detail d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-edit d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                </a>
                                <a href="#" class="button-delete d-none d-md-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon" class="img-fluid" width="16">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $('#table_transaction').DataTable( {
                responsive: true
            } );
        </script>
    @endpush
@endsection