@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 border-bottom d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            <form class="row row-cols-1 row-cols-md-2">
                <div class="col mb-3">
                    <label for="no_invois" class="form-label">Nomor Invois</label>
                    <input type="number" class="form-control" id="no_invois">
                </div>
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="col mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" class="form-control" id="total">
                </div>
                <div class="col mb-3">
                    <label for="product_name" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="product_name">
                </div>
                <div class="col mb-3">
                    <label for="stock" class="form-label">Sisa Stok</label>
                    <input type="number" class="form-control" id="stock">
                </div>
                <div class="col mb-3">
                    <label for="unit_price" class="form-label">Harga Satuan</label>
                    <input type="number" class="form-control" id="unit_price">
                </div>
                <div class="col mb-3">
                    <label for="selling_quantity" class="form-label">Jumlah Jual</label>
                    <input type="number" class="form-control" id="selling_quantity">
                </div>
                <div class="col mb-3">
                    <label for="total_payment" class="form-label">Total Pembayaran</label>
                    <input type="number" class="form-control" id="total_payment">
                </div>
                <div class="col">
                    <button type="button" class="button-primary">Tambah Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row me-lg-4 mt-4">
        <div class="col-12 pe-lg-0">
            <a href="#" class="d-none d-md-inline-block button-primary mb-2">Cetak Invois</a>
            <div class="wrapper-table">
                <table id="table_reseller" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Barang</th>
                            <th>Total Harga</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Minyak Dewantari</td>
                            <td>Rp. 135.000</td>
                            <td>10</td>
                            <td>Rp. 1.350.000</td>
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
                            <td>Ramuan Diksa</td>
                            <td>Rp. 275.000</td>
                            <td>2</td>
                            <td>Rp. 550.000</td>
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
                            <td>Barang Lain</td>
                            <td>Rp. 1.000.000</td>
                            <td>10</td>
                            <td>Rp. 100.000.000</td>
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