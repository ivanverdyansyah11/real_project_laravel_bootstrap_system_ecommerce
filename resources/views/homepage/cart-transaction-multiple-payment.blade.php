@extends('layouts.main')

@section('content-homepage')
    @php
        $cartId = [];
        $productSelectId = [];
        foreach ($cart as $item) {
            $cartId[] = $item->id;
            $productSelectId[] = $item->product->id;
        }
        $cartId = implode('+', $cartId);
        $productSelectId = implode('+', $productSelectId);
        $carts = $cart;
        $packages = array_filter($package);
    @endphp
    <div class="container my-5">
        <div class="row" style="margin-top: 32px;">
            <div class="col-12">
                @if (session()->has('success'))
                    <div class="alert alert-success w-100 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif(session()->has('failed'))
                    <div class="alert alert-danger w-100 mb-4" role="alert">
                        {{ session('failed') }}
                    </div>
                @endif
                <form action="{{ route('transaction-store-product', $cartId) }}" method="POST" class="w-100"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @foreach ($carts as $i => $cart)
                        <input type="hidden" value="{{ $cart->id }}" id="cart_id">
                    @endforeach
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Ringkasan Pembayaran</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="day_limit" class="form-label">Batas Hari Pembayaran</label>
                                    <input readonly type="text" class="form-control" id="day_limit"
                                        value="{{ Carbon\Carbon::parse($carts[0]->updated_at)->addDay()->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hour_limit" class="form-label">Batas Jam Pembayaran</label>
                                    <input readonly type="text" class="form-control" id="hour_limit"
                                        value="{{ Carbon\Carbon::parse($carts[0]->updated_at)->format('H:i:s') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="payments_id" class="form-label">Pembayaran</label>
                                    <select required name="payments_id" id="payments_id" class="form-control @error('payments_id') is-invalid @enderror">
                                        <option value="">Pilih pembayaran</option>
                                        @foreach ($payments as $payment)
                                            @if ($transaction[0]->shipping == 'ekspedisi')
                                                @if ($payment->owner_name != '')
                                                    <option value="{{ $payment->id }}">{{ $payment->bank_name }}</option>
                                                @endif
                                            @else
                                                <option value="{{ $payment->id }}">{{ $payment->bank_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('payments_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="owner_name" class="form-label">Pemilik Bank</label>
                                    <input readonly type="text" class="form-control" id="owner_name">
                                </div>
                                <div class="col-12">
                                    <label for="account_number" class="form-label">Nomor Rekening</label>
                                    <input readonly type="text" class="form-control" id="account_number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-body-title mb-4">Total Pembelian</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    @php
                                        $totalPayment = 0;
                                        foreach ($transaction as $payment) {
                                            $totalPayment += $payment->price_per_product * $payment->quantity;
                                        }
                                    @endphp
                                    <label for="total" class="form-label">Total Pembelian Barang</label>
                                    <input readonly type="text" class="form-control @error('total') is-invalid @enderror"
                                        id="total" name="total" value="{{ $totalPayment }}">
                                    @error('total')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @php
                                    $shippingPrice = 0;
                                    if ($transaction[0]->shipping == 'ekspedisi') {
                                        $shippingPrice = $transaction[0]->shipping_price;
                                    }
                                @endphp
                                <input required type="hidden"
                                       class="form-control @error('total_payment') is-invalid @enderror" id="total_payment"
                                       name="total_payment"
                                       value="{{ $totalPayment + $shippingPrice }}">
{{--                                <div class="col-md-6 mb-3">--}}
{{--                                    @php--}}
{{--                                        $shippingPrice = 0;--}}
{{--                                        if ($transaction[0]->shipping == 'ekspedisi') {--}}
{{--                                            $shippingPrice = $transaction[0]->shipping_price;--}}
{{--                                        }--}}
{{--                                    @endphp--}}
{{--                                    <label for="total_payment" class="form-label">Total Bayar</label>--}}
{{--                                    <input required type="number"--}}
{{--                                        class="form-control @error('total_payment') is-invalid @enderror" id="total_payment"--}}
{{--                                        name="total_payment" value="{{ old('total_payment') }}"--}}
{{--                                        min="{{ $totalPayment + $shippingPrice }}">--}}
{{--                                    @error('total_payment')--}}
{{--                                        <div class="invalid-feedback">--}}
{{--                                            {{ $message }}--}}
{{--                                        </div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                                @if ($transaction[0]->shipping == 'ekspedisi')
                                    <div class="col-12">
                                        <label for="shipping_price" class="form-label">Total Pengiriman</label>
                                        <input required type="number" class="form-control readonly" id="shipping_price"
                                            value="{{ $transaction[0]->shipping_price }}">
                                    </div>
                                    @if ($transaction[0]->shipping_price == null)
                                        <div class="col-12 mt-1">
                                            <p class="text-mention">Silahkan menunggu konfirmasi total pengiriman dari
                                                admin!</p>
                                        </div>
                                    @endif
                                @endif
{{--                                <div class="col-12 mt-3">--}}
{{--                                    <label for="total_change" class="form-label">Total Kembalian</label>--}}
{{--                                    <input readonly type="text" class="form-control" id="total_change">--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
{{--                            <h6 class="card-body-title mb-4">Upload Bukti Pembayaran</h6>--}}
                            <div class="row">
                                <div class="col-12 mb-3 d-flex flex-column" id="col-proof">
                                    <label for="proof_of_payment" class="form-label">Foto Bukti Pembayaran</label>
                                    <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found"
                                        class="rounded mb-2 img-preview" width="100" height="100"
                                        style="object-fit: cover;">
                                    <input required type="file"
                                        class="form-control input-file @error('proof_of_payment') is-invalid @enderror"
                                        name="proof_of_payment" id="proof_of_payment">
                                    @error('proof_of_payment')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="wrapper d-flex gap-2">
                                    <button type="submit" class="button-primary">Selesai Pembayaran</button>
                                    <a href="{{ route('cart.index') }}" class="button-dark">Batal Lanjutkan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // $(document).on('change', '#total_payment', function() {
            //     if ($('#shipping_price').length > 0) {
            //         if (parseInt($('#total').val()) + parseInt($('#shipping_price').val()) < parseInt($(
            //                 '#total_payment').val())) {
            //             let total = parseInt($('#total').val()) + parseInt($('#shipping_price').val())
            //             $('#total_change').val(parseInt($('#total_payment').val()) - total)
            //         } else {
            //             $('#total_change').val('0')
            //         }
            //     } else {
            //         if (parseInt($('#total').val()) < parseInt($('#total_payment').val())) {
            //             $('#total_change').val(parseInt($('#total_payment').val()) - parseInt($('#total').val()))
            //         } else {
            //             $('#total_change').val('0')
            //         }
            //     }
            // });

            $(document).on('change', '#payments_id', function() {
                let id = $(this).val();
                if (id != '') {
                    $.ajax({
                        type: 'get',
                        url: '/homepage/getPayment/' + id,
                        success: function(payment) {
                            if (payment.status == 'success') {
                                if (payment.data.bank_name != 'Cash') {
                                    $('#col-proof').removeClass('d-none');
                                    $('#proof_of_payment').attr('required', true);
                                } else {
                                    $('#col-proof').addClass('d-none');
                                    $('#proof_of_payment').removeAttr('required');
                                }
                                $('#owner_name').val(payment.data.owner_name);
                                $('#account_number').val(payment.data.account_number);
                            }
                        }
                    });
                } else {
                    $('#col-proof').addClass('d-none');
                    $('#owner_name').val('');
                    $('#account_number').val('');
                }
            });

            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });
        </script>
    @endpush
@endsection
