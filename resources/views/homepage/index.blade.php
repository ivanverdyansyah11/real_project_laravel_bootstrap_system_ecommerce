@extends('layouts.main')

@section('content-homepage')
    <section class="hero d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/images/homepage/background-hero-homepage.svg') }}" alt="Background Hero Homepage"
            class="img-fluid">
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
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 content-gap">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card-product text-center ">
                            <img src="{{ file_exists('assets/images/product/' . $product->image) && $product->image ? asset('assets/images/product/' . $product->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                alt="Product Image">
                            <p class="product-name">{{ $product->name }}</p>
                            @if ($product->stock > 0)
                                <a href="{{ route('product', $product->id) }}">Lebih Detail</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
