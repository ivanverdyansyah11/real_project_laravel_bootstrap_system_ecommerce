@extends('layouts.main')

@section('content-dashboard')
    @php
        $uniqueTransactionsAll = [];
        $invoiceTransactionsAll = [];
        foreach ($transactionAll as $transaction) {
            if (!in_array($transaction->invois, $invoiceTransactionsAll)) {
                $uniqueTransactionsAll[] = $transaction;
                $invoiceTransactionsAll[] = $transaction->invois;
            }
        }

        $uniqueTransactionsPending = [];
        $invoiceTransactionsPending = [];
        foreach ($transactionPending as $transaction) {
            if (!in_array($transaction->invois, $invoiceTransactionsPending)) {
                $uniqueTransactionsPending[] = $transaction;
                $invoiceTransactionsPending[] = $transaction->invois;
            }
        }

        $uniqueTransactionsFinish = [];
        $invoiceTransactionsFinish = [];
        foreach ($transactionFinish as $transaction) {
            if (!in_array($transaction->invois, $invoiceTransactionsFinish)) {
                $uniqueTransactionsFinish[] = $transaction;
                $invoiceTransactionsFinish[] = $transaction->invois;
            }
        }

        $uniqueTransactionsConfirmation = [];
        $invoiceTransactionsConfirmation = [];
        foreach ($transactionConfirmation as $transaction) {
            if (!in_array($transaction->invois, $invoiceTransactionsConfirmation)) {
                $uniqueTransactionsConfirmation[] = $transaction;
                $invoiceTransactionsConfirmation[] = $transaction->invois;
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
            <div class="card">
                <div class="card-body">
                    <h6 class="card-body-title mb-4">Rincian Pembelian</h6>
                    <div class="wrapper d-flex">
                        <button type="button" class="link-badge link-all active">Transaksi Semua</button>
                        <button type="button" class="link-badge link-finish">Transaksi Selesai</button>
                        <button type="button" class="link-badge link-pending">Transaksi Ditunda</button>
                        <button type="button" class="link-badge link-confirmation">Transaksi Menunggu Pembayaran</button>
                    </div>
                    <div class="row position-relative">
                        <div class="col-12 col-card-all active">
                            <div class="row">
                                @foreach ($uniqueTransactionsAll as $transaction)
                                    <div class="col-12 d-flex gap-3 pt-3 pb-2">
                                        <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2 img-preview" width="100"
                                            height="100" style="object-fit: cover;">
                                        <div class="wrapper d-flex justify-content-between align-items-center w-100">
                                            <div class="wrapper">
                                                @php
                                                    if ($transaction->status == 1) {
                                                        $statusTransaction = 'Transaksi Selesai';
                                                    } elseif ($transaction->status == 0) {
                                                        $statusTransaction = 'Transaksi Ditunda';
                                                    } elseif ($transaction->status == 2) {
                                                        $statusTransaction = 'Transaksi Menunggu Pembayaran';
                                                    }
                                                @endphp
                                                <button type="button"
                                                    class="badge-primary mb-2">{{ $statusTransaction }}</button>
                                                <h6 class="card-body-subtitle mb-1">{{ $transaction->product->name }}</h6>
                                                <p class="card-body-caption">Nomor Invois: {{ $transaction->invois }}</p>
                                            </div>
                                            @if ($transaction->status == 2)
                                                <a href="{{ route('cart-transaction', $transaction->invois) }}"
                                                    class="button-primary">Lanjutkan Pembayaran</a>
                                            @else
                                                <div class="wrapper text-end">
                                                    <p class="card-body-caption mb-1">Total Belanja</p>
                                                    <h6 class="card-body-subtitle mb-3">Rp.
                                                        {{ $transaction->total_per_product == null ? number_format($transaction->total, 2, ',', '.') : number_format($transaction->total_per_product, 2, ',', '.') }}
                                                    </h6>
                                                    <div class="wrapper d-flex gap-2">
                                                        @if ($transaction->proof_of_payment == null)
                                                            <a href="{{ route('transaction.edit', $transaction->id) }}"
                                                                class="button-primary-reverse">Upload Bukti Pembayaran</a>
                                                        @endif
                                                        <a href="{{ route('transaction.show', $transaction->id) }}"
                                                            class="button-primary">Detail Transaksi</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-card-pending">
                            <div class="row">
                                @foreach ($uniqueTransactionsPending as $transaction)
                                    <div class="col-12 d-flex gap-3 pt-3 pb-2">
                                        <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2 img-preview" width="100"
                                            height="100" style="object-fit: cover;">
                                        <div class="wrapper d-flex justify-content-between align-items-center w-100">
                                            <div class="wrapper">
                                                <h6 class="card-body-subtitle mb-1">{{ $transaction->product->name }}</h6>
                                                <p class="card-body-caption">Nomor Invois: {{ $transaction->invois }}</p>
                                            </div>
                                            <div class="wrapper text-end">
                                                <p class="card-body-caption mb-1">Total Belanja</p>
                                                <h6 class="card-body-subtitle mb-3">Rp.
                                                    {{ $transaction->total_per_product == null ? number_format($transaction->total, 2, ',', '.') : number_format($transaction->total_per_product, 2, ',', '.') }}
                                                </h6>
                                                <div class="wrapper d-flex gap-2">
                                                    @if ($transaction->proof_of_payment == null)
                                                        <a href="{{ route('transaction.edit', $transaction->id) }}"
                                                            class="button-primary-reverse">Upload Bukti Pembayaran</a>
                                                    @endif
                                                    <a href="{{ route('transaction.show', $transaction->id) }}"
                                                        class="button-primary">Detail Transaksi</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-card-finish">
                            <div class="row">
                                @foreach ($uniqueTransactionsFinish as $transaction)
                                    <div class="col-12 d-flex gap-3 pt-3 pb-2">
                                        <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2 img-preview" width="100"
                                            height="100" style="object-fit: cover;">
                                        <div class="wrapper d-flex justify-content-between align-items-center w-100">
                                            <div class="wrapper">
                                                <h6 class="card-body-subtitle mb-1">{{ $transaction->product->name }}</h6>
                                                <p class="card-body-caption">Nomor Invois: {{ $transaction->invois }}</p>
                                            </div>
                                            <div class="wrapper text-end">
                                                <p class="card-body-caption mb-1">Total Belanja</p>
                                                <h6 class="card-body-subtitle mb-3">Rp.
                                                    {{ $transaction->total_per_product == null ? number_format($transaction->total, 2, ',', '.') : number_format($transaction->total_per_product, 2, ',', '.') }}
                                                </h6>
                                                <div class="wrapper d-flex gap-2">
                                                    @if ($transaction->proof_of_payment == null)
                                                        <a href="{{ route('transaction.edit', $transaction->id) }}"
                                                            class="button-primary-reverse">Upload Bukti Pembayaran</a>
                                                    @endif
                                                    <a href="{{ route('transaction.show', $transaction->id) }}"
                                                        class="button-primary">Detail Transaksi</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-card-confirmation">
                            <div class="row">
                                @foreach ($uniqueTransactionsConfirmation as $transaction)
                                    <div class="col-12 d-flex gap-3 pt-3 pb-2">
                                        <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                            alt="Image Not Found" class="rounded mb-2 img-preview" width="100"
                                            height="100" style="object-fit: cover;">
                                        <div class="wrapper d-flex justify-content-between align-items-center w-100">
                                            <div class="wrapper">
                                                <h6 class="card-body-subtitle mb-1">{{ $transaction->product->name }}
                                                </h6>
                                                <p class="card-body-caption">Nomor Invois: {{ $transaction->invois }}
                                                </p>
                                            </div>
                                            <a href="{{ route('cart-transaction', $transaction->invois) }}"
                                                class="button-primary">Lanjutkan Pembayaran</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            const cardAll = document.querySelector('.col-card-all');
            const cardPending = document.querySelector('.col-card-pending');
            const cardFinish = document.querySelector('.col-card-finish');
            const cardConfirmation = document.querySelector('.col-card-confirmation');
            const linkBadgeAll = document.querySelector('.link-all');
            const linkBadgePending = document.querySelector('.link-pending');
            const linkBadgeFinish = document.querySelector('.link-finish');
            const linkBadgeConfirmation = document.querySelector('.link-confirmation');

            linkBadgeAll.addEventListener('click', function() {
                linkBadgeAll.classList.add('active');
                linkBadgePending.classList.remove('active');
                linkBadgeFinish.classList.remove('active');
                linkBadgeConfirmation.classList.remove('active');
                cardAll.classList.add('active');
                cardPending.classList.remove('active');
                cardFinish.classList.remove('active');
                cardConfirmation.classList.remove('active');
            });

            linkBadgePending.addEventListener('click', function() {
                linkBadgeAll.classList.remove('active');
                linkBadgePending.classList.add('active');
                linkBadgeFinish.classList.remove('active');
                linkBadgeConfirmation.classList.remove('active');
                cardAll.classList.remove('active');
                cardPending.classList.add('active');
                cardFinish.classList.remove('active');
                cardConfirmation.classList.remove('active');
            });

            linkBadgeFinish.addEventListener('click', function() {
                linkBadgeAll.classList.remove('active');
                linkBadgePending.classList.remove('active');
                linkBadgeFinish.classList.add('active');
                linkBadgeConfirmation.classList.remove('active');
                cardAll.classList.remove('active');
                cardPending.classList.remove('active');
                cardFinish.classList.add('active');
                cardConfirmation.classList.remove('active');
            });

            linkBadgeConfirmation.addEventListener('click', function() {
                linkBadgeAll.classList.remove('active');
                linkBadgePending.classList.remove('active');
                linkBadgeFinish.classList.remove('active');
                linkBadgeConfirmation.classList.add('active');
                cardAll.classList.remove('active');
                cardPending.classList.remove('active');
                cardFinish.classList.remove('active');
                cardConfirmation.classList.add('active');
            });
        </script>
    @endpush
@endsection
