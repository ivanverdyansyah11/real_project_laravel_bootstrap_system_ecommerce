@extends('layouts.main')

@section('content-homepage')
    <section class="hero d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/images/homepage/background-hero-homepage.jpg') }}" alt="Background Hero Homepage"
            class="img-fluid w-100">
    </section>
    <section class="about justify-content-center align-items-center position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                    <h3 class="title mb-3">Tentang Minyak Dewantari</h3>
                    <p class="paragraph">Minyak Dewantari memberikan kesempurnaan, dan kenyamanan pada tubuh, membuat
                        otot-otot menjadi relaxs, sehingga dapat membantu tidur menjadi lebih nyenyak, ketika tidur terasa
                        nyenyak disitulah proses penyembuhan terjadi. Disamping itu minyak Dewantari juga bersifat memberi
                        tenaga, menambah semangat atau energizer, sehingga tubuh yang terasa lelah dan kurang nyaman dapat
                        kembali bertenaga.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="popular section-gap">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex align-items-center gap-3">
                    <h2 class="title">Produk Populer</h2>
                    <div class="title-line"></div>
                </div>
            </div>
            <div class="row content-gap">
                @if(count($products) == 0)
                    <div class="col-12 text-center my-3">
                        <p class="text-not-found">Not found favorite product!</p>
                    </div>
                @else
                    @foreach ($products as $transaction)
                        <div class="col-12 col-md-4 col-lg-3 mb-3">
                            <div class="card-product text-center ">
                                <img src="{{ file_exists('assets/images/product/' . $transaction->product->image) && $transaction->product->image ? asset('assets/images/product/' . $transaction->product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                    alt="Product Image">
                                <div class="wrapper d-flex align-items-center justify-content-between">
                                    <p class="product-name">{{ $transaction->product->name }}</p>
                                    <p class="product-name text-capitalize">{{ $transaction->total_quantity . ' ' . $transaction->product->unit }}</p>
                                </div>
                                <a href="{{ route('product', $transaction->product->id) }}">Lebih Detail</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
