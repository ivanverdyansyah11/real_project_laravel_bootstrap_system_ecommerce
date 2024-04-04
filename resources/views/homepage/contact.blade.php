@extends('layouts.main')

@section('content-homepage')
    <div class="container my-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <img src="{{ asset('assets/images/homepage/contact-banner.jpg') }}" alt="Contact Banner" class="w-100"
                    height="300" style="object-fit: cover; border-radius: 8px">
            </div>
            <div class="col-md-6 col-lg-5 mt-4">
                <h4 class="contact-title">Visi</h4>
                <p class="contact-description">Setiap orang mengalami peningkatan kesehatan tubuh, pikiran, dan jiwa.</p>
                <h4 class="contact-title mt-3">Misi</h4>
                <p class="contact-description">Memperbaiki tubuh orang, menjadi sehat, kuat dan seimbang. Meningkatkan
                    kesadaran dan kematangan.</p>
            </div>
        </div>
        <div class="row mt-5 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card-contact">
                    <h2 class="contact-headline">Kontak Kami</h2>
                    <ul>
                        <li>
                            <a href="mailto:minyakdewantari@gmail.com" class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/images/homepage/email.png') }}" alt="Email Icon" width="18"
                                    height="18">
                                <span class="contact-sosmed">minyakdewantari@gmail.com</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?phone=087789488173"
                                class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/images/homepage/phone.png') }}" alt="Whatsapp Icon"
                                    width="18" height="18">
                                <span class="contact-sosmed">+62 877-8948-8173</span>
                            </a>
                        </li>
                        <li>
                            <span class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/images/homepage/address.png') }}" alt="Address Icon"
                                    width="18" height="18">
                                <span class="contact-sosmed">Jl. Ahmad Yani Utara Gg. Sriti No. 9, Peguyangan, Kec. Denpasar
                                    Utara, Kota Denpasar, Bali 80115</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 mt-4">
                <div class="card-contact-primary">
                    <h2 class="contact-headline">Tinggalkan Pesan</h2>
                    <form class="d-flex flex-column gap-2 ">
                        <input type="text" class="input" placeholder="Name">
                        <input type="text" class="input" placeholder="Email">
                        <input type="text" class="input" placeholder="Message">
                        <button class="button-dark w-100 mt-3">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
