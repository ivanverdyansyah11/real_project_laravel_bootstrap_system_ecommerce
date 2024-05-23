@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if (session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
        </div>
        <div class="col-12 mb-2 d-flex gap-2">
            <a target="_blank" href="{{ route('export-invoice', $transactions[0]->id) }}"
                class="button-primary text-nowrap">Cetak Invoice PDF</a>
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
                                        <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2" width="100" height="100"
                                            style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="product_name" class="form-label">Nama Produk</label>
                                        <input readonly type="text" class="form-control" id="product_name"
                                            value="{{ $transaction->product->name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="package_name" class="form-label">Nama Paket</label>
                                        @php
                                            $packageName = '-';
                                            $packages = array_filter($packages);
                                            if (count($packages) != 0 && count($transactions) != 1) {
                                                foreach ($packages as $package) {
                                                    if ($package->products_id == $transaction->product->id) {
                                                        $packageName = $package->name;
                                                    }
                                                }
                                            } elseif (count($packages) != 0) {
                                                if ($packages[0] != null) {
                                                    $packageName = $packages[0]->name;
                                                }
                                            }
                                        @endphp
                                        <input readonly type="text" class="form-control" id="package_name"
                                            value="{{ $packageName }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        @php
                                            $packagePrice = $transaction->product->selling_price;
                                            if (count($packages) != 0 && count($transactions) != 1) {
                                                foreach ($packages as $package) {
                                                    if ($package->products_id == $transaction->product->id) {
                                                        $packagePrice = $package->selling_price;
                                                    }
                                                }
                                            } elseif (count($packages) != 0) {
                                                if ($packages[0] != null) {
                                                    $packagePrice = $packages[0]->selling_price;
                                                }
                                            }
                                        @endphp
                                        <label for="selling_price" class="form-label">Harga/botol</label>
                                        <input readonly type="text" class="form-control" id="selling_price"
                                            value="Rp. {{ number_format($packagePrice, 2, ',', '.') }}">
                                    </div>
                                    @if ($transaction->payments_id != null)
                                        <div class="col-md-6 mb-3">
                                            <label for="total_payment" class="form-label">Total Per Produk</label>
                                            <input readonly type="text" class="form-control" id="total_payment"
                                                value="Rp. {{ $transaction->total_per_product == null ? number_format($transaction->total_payment, 2, ',', '.') : number_format($transaction->total_per_product, 2, ',', '.') }}">
                                        </div>
                                    @endif
                                    <div class="{{ $transaction->payments_id == null ? 'col-6' : 'col-12' }} mb-3">
                                        <label for="quantity" class="form-label">Kuantitas Dibeli</label>
                                        <input readonly type="number"
                                            class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                            value="{{ $transaction->quantity }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Data Reseller</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="resellers_id" class="form-label">Nama Reseller</label>
                                    <input readonly type="text" class="form-control" id="resellers_id"
                                        value="{{ $transaction->reseller ? $transaction->reseller->name : '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($transaction->payments_id != null)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h6 class="card-body-title mb-4">Data Pembayaran</h6>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="bank_name" class="form-label">Pembayaran Bank</label>
                                        <input readonly type="text" class="form-control" id="bank_name"
                                            value="{{ $transaction->payment->bank_name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="owner_name" class="form-label">Nama Pemilik</label>
                                        <input readonly type="text" class="form-control" id="owner_name"
                                            value="{{ $transaction->payment->owner_name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="account_number" class="form-label">Nomor Rekening</label>
                                        <input readonly type="text" class="form-control" id="account_number"
                                            value="{{ $transaction->payment->account_number }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Data Pengiriman</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="shipping" class="form-label">Pengiriman Barang</label>
                                    <input readonly type="text" class="form-control text-capitalize" id="shipping"
                                        value="{{ $transaction->shipping }}">
                                </div>
                                @if ($transaction->shipping == 'ekspedisi')
                                    <div class="col-12 mb-3" id="formShippingAddress">
                                        <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                                        <input readonly type="text" class="form-control" id="shipping_address"
                                            value="{{ $transaction->address }}">
                                    </div>
                                @endif
                                @if ($transaction->payments_id == null)
                                    <div class="wrapper d-flex gap-2">
                                        <button type="button" class="button-dark" onClick="history_back()">Kembali ke
                                            Halaman</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($transaction->payments_id != null)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h6 class="card-body-title mb-4">Total Pembelian</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="total" class="form-label">Total</label>
                                        <input readonly type="text" class="form-control" id="total"
                                            value="Rp. {{ number_format($transaction->total, 2, ',', '.') }}">
                                        <input type="hidden" class="form-control" id="total_value"
                                            value="{{ $transaction->total }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="total_payment" class="form-label">Total Bayar</label>
                                        <input readonly type="text" class="form-control" id="total_payment"
                                            value="Rp. {{ number_format($transaction->total_payment, 2, ',', '.') }}">
                                        <input type="hidden" class="form-control" id="total_payment_value"
                                            value="{{ $transaction->total_payment }}">
                                    </div>
                                    @if ($transaction->shipping == 'ekspedisi')
                                        <div class="col-12">
                                            <label for="shipping_price" class="form-label">Total Pengiriman</label>
                                            <input readonly type="text" class="form-control" id="shipping_price"
                                                value="Rp. {{ number_format($transaction->shipping_price, 2, ',', '.') }}">
                                            <input type="hidden" class="form-control" id="shipping_price_value"
                                                value="{{ $transaction->shipping_price }}">
                                        </div>
                                    @endif
                                    <div class="col-12 {{ $transaction->shipping == 'ekspedisi' ? 'mt-3' : '' }}">
                                        <label for="total_change" class="form-label">Total Kembalian</label>
                                        <input readonly type="text" class="form-control" id="total_change">
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
                                        <img src="{{ file_exists('assets/images/transaction/' . $transactions[0]->proof_of_payment) && $transactions[0]->proof_of_payment ? asset('assets/images/transaction/' . $transactions[0]->proof_of_payment) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2" width="100" height="100"
                                            style="object-fit: cover;">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="created_at" class="form-label">Transaksi Dilakukan</label>
                                        <input readonly type="text" class="form-control" id="created_at"
                                            value="{{ Carbon\Carbon::parse($transactions[0]->created_at)->format('l, d F Y') }}">
                                    </div>
                                    <div class="wrapper d-flex gap-2">
                                        <button type="button" class="button-dark" onClick="history_back()">Kembali ke
                                            Halaman</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            function history_back() {
                window.history.back();
            }

            if ($('#shipping_price_value').val() != '') {
                if ($('#total_value').val() + $('#shipping_price_value').val() < $('#total_payment_value').val()) {
                    let total = parseInt($('#total_value').val()) + parseInt($('#shipping_price_value').val())
                    $('#total_change').val(
                        `${new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(parseInt($('#total_payment_value').val()) - total)}`
                    )
                } else {
                    $('#total_change').val('Rp. 0')
                }
            } else {
                if ($('#total_value').val() < $('#total_payment_value').val()) {
                    $('#total_change').val(
                        `${new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(parseInt($('#total_payment_value').val()) - parseInt($('#total_value').val()))}`
                    )
                } else {
                    $('#total_change').val('Rp. 0')
                }
            }
        </script>
    @endpush
@endsection
