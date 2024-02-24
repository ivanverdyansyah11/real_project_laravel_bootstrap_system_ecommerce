@extends('layouts.main')

@section('content-dashboard')
    <div class="row row-cols-1 row-cols-lg-2 me-lg-4" style="margin-top: 32px;">
        <div class="col">
            <div class="dashboard-menu p-3">
                <div class="wrapper d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/dashboard/stock-product.png') }}" alt="Stock Product" class="img-fluid" width="32">
                    <p class="menu-title mb-0">Stok Produk</p>
                </div>
                <div class="row row-cols-3 child-menu">
                    <div class="col">
                        <p class="child-title">Minyak Dewantari</p>
                        <p class="child-value">350</p>
                    </div>
                    <div class="col">
                        <p class="child-title">Ramuan Diksa</p>
                        <p class="child-value">350</p>
                    </div>
                    <div class="col">
                        <p class="child-title">Kapsul Visnhu</p>
                        <p class="child-value">350</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mt-4 mt-lg-0 pe-lg-0">
            <div class="dashboard-menu p-3">
                <div class="wrapper d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/dashboard/category.png') }}" alt="Stock Product" class="img-fluid" width="26">
                    <p class="menu-title mb-0">Category</p>
                </div>
                <div class="row row-cols-3 child-category">
                    <div class="col">
                        <div class="card-category p-3 rounded text-center">
                            <p class="category-title">Minyak Dewantari</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-category p-3 rounded text-center">
                            <p class="category-title">Ramuan Diksa</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-category p-3 rounded text-center">
                            <p class="category-title">Kapsul Visnhu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row me-lg-4 mt-4">
        <div class="col-12 pe-lg-0">
            <a href="#" class="button-primary mb-2">Buat Produk</a>
            <div class="wrapper-table">
                <table id="table_produk" class="table display responsive nowrap table-striped" style="width:100%">
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
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td class="wrapper d-flex gap-2">
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
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td class="wrapper d-flex gap-2">
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
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>66</td>
                            <td class="wrapper d-flex gap-2">
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
                            <td>Cedric Kelly</td>
                            <td>Senior Javascript Developer</td>
                            <td>Edinburgh</td>
                            <td>22</td>
                            <td class="wrapper d-flex gap-2">
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
            $('#table_produk').DataTable( {
                responsive: true
            } );
        </script>
    @endpush
@endsection