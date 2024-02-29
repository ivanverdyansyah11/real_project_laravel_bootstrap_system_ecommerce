@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="wrapper-frame">
                    <iframe class="frame-testimonial" src="https://www.youtube.com/embed/CQBKnEyZDas?si=rwdu6MoxkyAZFM9g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-12">
                <img src="{{ asset('assets/images/homepage/testimonial-product.svg') }}" alt="Testimonial Product" class="img-fluid">
            </div>
        </div>
    </div>
@endsection
