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
                <div class="col-12 mb-3">
                    <label for="buyers_name" class="form-label">Nama Pembeli</label>
                    <input required type="text" class="form-control" id="buyers_name" name="buyers_name">
                </div>
                <input type="hidden" class="form-control" id="shipping" name="shipping" value="cashier">
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
                <div class="col-md-4 mb-3">
                    <label for="total" class="form-label">Total Pembelian Barang</label>
                    <input readonly type="text" class="form-control @error('total') is-invalid @enderror" id="total"
                        name="total" value="{{ $total }}">
                    @error('total')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="total_payment" class="form-label">Total Bayar</label>
                    <input required type="text" class="form-control @error('total_payment') is-invalid @enderror"
                        id="total_payment" name="total_payment" value="{{ old('total_payment') }}"
                        min="{{ $total }}">
                    @error('total_payment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="total_change" class="form-label">Total Kembalian</label>
                    <input readonly type="text" class="form-control" id="total_change">
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button id="button-submit" type="submit" disabled class="button-primary">Lakukan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.cashier')
    @push('js')
        <script>
            $("#total_payment").keyup(function() {
                let total = $('#total').val().replace('Rp. ', '')
                total = total.replace(/\./g, '')
                let total_payment = $('#total_payment').val().replace('Rp. ', '')
                total_payment = total_payment.replace(/\./g, '')

                let totalChange = total_payment - total
                if (totalChange < 0) {
                    totalChange = 0
                    $("#button-submit").attr("disabled", true)
                } else {
                    totalChange = totalChange
                    $("#button-submit").attr("disabled", false)
                }
                $('#total_change').val(formatRupiah(totalChange, 'Rp. '));

                function formatRupiah(angka, prefix) {
                    angka = angka.toString();
                    let number_string = angka.replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
                }
            });

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

            let total = document.getElementById('total')
            total.value = formatRupiah(total.value, 'Rp. ');

            let totalPayment = document.getElementById('total_payment')
            totalPayment.addEventListener('keyup', function(e)
            {
                totalPayment.value = formatRupiah(this.value, 'Rp. ');
            });

            function formatRupiah(angka, prefix)
            {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split    = number_string.split(','),
                    sisa     = split[0].length % 3,
                    rupiah     = split[0].substr(0, sisa),
                    ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        </script>
    @endpush
@endsection
