@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
        </div>
        <div class="col-12 pe-lg-0">
            <form class="row">
                <div class="col-12">
                    @foreach ($transactions as $transaction)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-body-title mb-4">Ringkasan Produk</h6>
                                <div class="row">
                                    <div class="col-12 mb-3 d-flex flex-column">
                                        <label class="form-label">Foto Produk</label>
                                        <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2" width="100" height="100" style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="product_name" class="form-label">Nama Produk</label>
                                        <input readonly type="text" class="form-control" id="product_name" value="{{ $transaction->product->name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="stock" class="form-label">Sisa Stok</label>
                                        <input readonly type="text" class="form-control" id="stock" value="{{ $transaction->product->stock }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="price_per_product" class="form-label">Harga Satuan</label>
                                        <input readonly type="text" class="form-control" id="price_per_product" value="Rp. {{ number_format($transaction->price_per_product, 2, ",", ".") }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="total_payment" class="form-label">Total Per Produk</label>
                                        <input readonly type="text" class="form-control" id="total_payment" value="Rp. {{ $transaction->total_per_product == null ? number_format($transaction->total_payment, 2, ",", ".") : number_format($transaction->total_per_product, 2, ",", ".") }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                                        <input readonly type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" value="{{ $transaction->quantity }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Data Karyawan</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="resellers_id" class="form-label">Nama Karyawan</label>
                                    <input readonly type="text" class="form-control" id="resellers_id" value="{{ $transaction->reseller ? $transaction->reseller->name : '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Total Pembelian</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input readonly type="text" class="form-control" id="total" value="Rp. {{ number_format($transaction->total, 2, ",", ".") }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="total_payment" class="form-label">Total Bayar</label>
                                    <input readonly type="text" class="form-control" id="total_payment" value="Rp. {{ number_format($transaction->total_payment, 2, ",", ".") }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Bukti Pembayaran</h6>
                            <div class="row">
                                <div class="col-12 mb-3 d-flex flex-column">
                                    <label for="proof_of_payment" class="form-label">Foto Bukti Pembayaran</label>
                                    <img src="{{ file_exists('assets/images/transaction/' . $transactions[0]->proof_of_payment) && $transactions[0]->proof_of_payment ? asset('assets/images/transaction/' . $transactions[0]->proof_of_payment) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2" width="100" height="100" style="object-fit: cover;">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="created_at" class="form-label">Tanggal Dilakukan</label>
                                    <input readonly type="text" class="form-control" id="created_at" value="{{ Carbon\Carbon::parse($transactions[0]->created_at)->format('l, d F Y') }}">
                                </div>
                                <div class="wrapper d-flex gap-2">
                                    <button type="button" class="button-dark" onClick="history_back()">Kembali ke Halaman</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            function history_back() {
                window.history.back();
            }
        </script>
    @endpush
@endsection
