@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            <a href="#" class="d-none d-md-inline-block button-primary mb-2">Buat Penghargaan</a>
            <div class="wrapper-table">
                <table id="table_reseller" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Poin Diperlukan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>System Architect</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, eveniet.</td>
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
                            <td>2</td>
                            <td>Accountant</td>
                            <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Beatae, magnam?</td>
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
                            <td>3</td>
                            <td>Junior Technical Author</td>
                            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, aperiam!</td>
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
                            <td>4</td>
                            <td>Senior Javascript Developer</td>
                            <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugit, cupiditate?</td>
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
            $('#table_reseller').DataTable( {
                responsive: true
            } );
        </script>
    @endpush
@endsection