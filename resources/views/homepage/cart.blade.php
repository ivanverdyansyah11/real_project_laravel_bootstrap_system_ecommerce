@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
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
                        <h6 class="card-body-title mb-4">Rincian Pembelian <span class="text-caption">{{ count($carts) != 0 ? '(Pilih produk untuk melakukan pembelian)' : '' }}</span></h6>
                            <div class="row">
                                @if (count($carts) == 0)
                                    <div class="col-12">
                                        <p class="text-description">Tidak ada produk yang disimpan!</p>
                                    </div>
                                @else
                                    @foreach ($carts as $cart)
                                        <input type="checkbox" class="checkbox-cart" name="cart_id" id="{{ $cart->id }}" value="{{ $cart->id }}">
                                        <label class="col-12 d-flex gap-3 pt-3 pb-2" for="{{ $cart->id }}" style="cursor: pointer;">
                                            <img src="{{ file_exists('assets/images/product/' . $cart->product->image) && $cart->product->image ? asset('assets/images/product/' . $cart->product->image) : asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found" class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                                            <div class="wrapper d-flex justify-content-between align-items-center w-100">
                                                <div class="wrapper">
                                                    <h6 class="card-body-subtitle mb-1">{{ $cart->product->name }} ({{ $cart->quantity }} {{ $cart->product->unit }})</h6>
                                                    <p class="card-body-caption">Kategori Produk: {{ $cart->product->category->name }}</p>
                                                </div>
                                                <div class="wrapper text-end">
                                                    <p class="card-body-caption mb-1">Harga Produk</p>
                                                    <h6 class="card-body-subtitle mb-3">Rp. {{ number_format($cart->product->selling_price, 2, ",", ".") }}</h6>
                                                    <div class="wrapper d-flex gap-2">
                                                        {{-- <a href="{{ route('cart.edit', $cart->id) }}" class="button-primary">Transaksi Produk</a> --}}
                                                        <button type="button" class="button-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $cart->id }}">Hapus Produk</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        <form action="{{ route('create-session') }}" id="formCartId" method="POST">
                            @csrf
                            <button type="submit" class="button-primary mt-4 d-none">Lakukan Pembelian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.cart')
    @push('js')
        <script>
            $('[name="cart_id"]').on('change', function() {
                if ($(this).is(':checked')) {
                    var inputText = $('<input>').attr({
                        type: 'hidden',
                        name: 'cart_id[]',
                        id: $(this).val(),
                        value: $(this).val(),
                    });
                    $('#formCartId').append(inputText);
                    $('[for="' + $(this).attr('id') + '"]').addClass('active')
                } else {
                    $('#formCartId input[id="' + $(this).val() + '"]').remove();
                    $('[for="' + $(this).attr('id') + '"]').removeClass('active')
                }
            });

            $(document).change(function () {
                if ($('#formCartId input[name="cart_id[]"]').length != 0) {
                    $('#formCartId button').removeClass('d-none')
                } else {
                    $('#formCartId button').addClass('d-none')
                }
            })

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteCart').attr('action', '/homepage/cart/' + id);
            });
        </script>
    @endpush
@endsection
