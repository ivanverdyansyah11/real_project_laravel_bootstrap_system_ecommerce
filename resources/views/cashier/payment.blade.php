@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
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
        </div>
        <div class="col-12 pe-lg-0 mb-4">
            <form class="row" action="{{ route('store-payment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @php
                    $totalPerProduct = [];
                    foreach ($cashiers as $cashier) {
                        $totalPerProduct[] = $cashier->selling_price * $cashier->quantity;
                    }
                    $total = array_reduce(
                        $totalPerProduct,
                        function ($carry, $item) {
                            return $carry + $item;
                        },
                        0,
                    );
                @endphp
                <input type="hidden" name="status" value="1">
                <div class="col-12 mb-3 d-flex flex-column">
                    <label for="proof_of_payment" class="form-label">Foto Bukti Pembayaran</label>
                    <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found"
                        class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                    <input required type="file"
                        class="form-control input-file @error('proof_of_payment') is-invalid @enderror"
                        name="proof_of_payment" id="proof_of_payment">
                    @error('proof_of_payment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="shipping" class="form-label">Pengiriman Barang</label>
                    <select required class="form-control @error('shipping') is-invalid @enderror" id="shipping"
                        name="shipping">
                        <option value="">Pilih Pengiriman</option>
                        <option value="ekspedisi">Ekspedisi</option>
                        <option value="offline">Ambil ke Kantor Dewantari</option>
                    </select>
                    @error('shipping')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mb-3 d-none" id="formShippingPrice">
                    <label for="shipping_price" class="form-label">Harga Pengiriman</label>
                    <input type="number" class="form-control @error('shipping_price') is-invalid @enderror"
                        id="shipping_price" name="shipping_price">
                    @error('shipping_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mb-3 d-none" id="formShippingAddress">
                    <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                    <input type="text" class="form-control @error('shipping_address') is-invalid @enderror"
                        id="shipping_address" name="shipping_address">
                    @error('shipping_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="payments_id" class="form-label">Pembayaran</label>
                    <select required name="payments_id" id="payments_id" class="form-control"
                        @error('payments_id') is-invalid @enderror>
                        <option value="">Pilih pembayaran</option>
                        @foreach ($payments as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->bank_name }}</option>
                        @endforeach
                    </select>
                    @error('payments_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="owner_name" class="form-label">Pemilik Bank</label>
                    <input readonly type="text" class="form-control" id="owner_name">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="account_number" class="form-label">Nomor Rekening</label>
                    <input readonly type="text" class="form-control" id="account_number">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="total" class="form-label">Total Pembelian Barang</label>
                    <input readonly type="text" class="form-control @error('total') is-invalid @enderror" id="total"
                        name="total" value="{{ $total }}">
                    @error('total')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="total_payment" class="form-label">Total Bayar</label>
                    <input required type="number" class="form-control @error('total_payment') is-invalid @enderror"
                        id="total_payment" name="total_payment" value="{{ old('total_payment') }}"
                        min="{{ $total }}">
                    @error('total_payment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="button-primary">Lakukan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.cashier')
    @push('js')
        <script>
            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });

            $(document).on('change', '#shipping', function() {
                if ($('#shipping').val() == 'ekspedisi') {
                    $('#formShippingAddress').removeClass('d-none')
                    $('#formShippingPrice').removeClass('d-none')
                    $('#shipping_address').prop('required', true);
                    $('#shipping_price').prop('required', true);
                } else {
                    $('#formShippingAddress').addClass('d-none')
                    $('#formShippingPrice').addClass('d-none')
                    $('#shipping_address').prop('required', false);
                    $('#shipping_price').prop('required', false);
                }
            })

            $(document).on('change', '#payments_id', function() {
                let id = $(this).val();
                if (id != '') {
                    $.ajax({
                        type: 'get',
                        url: '/homepage/getPayment/' + id,
                        success: function(payment) {
                            if (payment.status == 'success') {
                                $('#owner_name').val(payment.data.owner_name);
                                $('#account_number').val(payment.data.account_number);
                            }
                        }
                    });
                } else {
                    $('#owner_name').val('');
                    $('#account_number').val('');
                }
            });
        </script>
    @endpush
@endsection
