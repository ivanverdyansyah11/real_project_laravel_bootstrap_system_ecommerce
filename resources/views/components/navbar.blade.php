@php
    $uniqueTransactions = [];
    $invoiceTransactions = [];
    foreach ($transactions as $transaction) {
        if (!in_array($transaction->invois, $invoiceTransactions)) {
            $uniqueTransactions[] = $transaction;
            $invoiceTransactions[] = $transaction->invois;
        }
    }
@endphp

<nav class="navbar navbar-expand-lg bg-body-tertiary py-2">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="{{ route('homepage') }}">
            <img src="{{ asset('assets/images/brand/brand-logo.svg') }}" alt="Brand Logo" width="56">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link {{ Route::is('homepage') ? 'active' : '' }}"
                    href="{{ route('homepage') }}">Beranda</a>
                <a class="nav-link {{ Route::is('products') ? 'active' : '' }}"
                    href="{{ route('products') }}">Produk</a>
                <a class="nav-link {{ Route::is('testimonial') ? 'active' : '' }}"
                    href="{{ route('testimonial') }}">Testimoni</a>
                <a class="nav-link {{ Route::is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak
                    Kami</a>
            </div>
        </div>
        <div class="wrapper d-none d-lg-flex gap-2 align-items-center">
            <a href="{{ route('cart.index') }}" class="wrapper-icon d-flex align-items-center justify-content-center">
                <div class="icon-cart"></div>
            </a>
            <div class="wrapper-popup position-relative">
                <button
                    class="wrapper-icon d-flex align-items-center justify-content-center position-relative button-notification">
                    <div class="icon-notification"></div>
                </button>
                <div class="popup-notification">
                    @if ($uniqueTransactions != [])
                        @foreach ($uniqueTransactions as $transaction)
                            @if ($transaction->status == 2)
                                <div class="notification-item">
                                    <p>Admin baru saja menambahakan jumlah pengiriman, lanjutkan pembayaran!</p>
                                    <div class="wrapper d-flex justify-content-between align-items-center mt-1">
                                        <span>{{ $transaction->updated_at }}</span>
                                        <a href="{{ route('transaction.show', $transaction->id) }}">See detail</a>
                                    </div>
                                </div>
                            @elseif($transaction->status == 1)
                                <div class="notification-item">
                                    <p>Admin baru saja menyetujui transaksi anda!</p>
                                    <div class="wrapper d-flex justify-content-between align-items-center mt-1">
                                        <span>{{ $transaction->updated_at }}</span>
                                        <a href="{{ route('transaction.show', $transaction->id) }}">See detail</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="notification-item">
                            <p>Tidak ada pemberitahuan terbaru!</p>
                        </div>
                    @endif
                </div>
            </div>
            <button class="wrapper-icon d-flex align-items-center justify-content-center">
                <div class="icon-search"></div>
            </button>
            @if (auth()->user() == null)
                <a href="{{ route('login') }}" class="button-primary">Join Member Now</a>
            @else
                <div class="wrapper-popup position-relative">
                    <button class="d-inline-block position-relative button-profile"
                        style="border: none; background-color: transparent;">
                        <img src="{{ file_exists('assets/images/profile/' . auth()->user()->image) && auth()->user()->image ? asset('assets/images/profile/' . auth()->user()->image) : asset('assets/images/profile/profile-not-found.jpg') }}"
                            alt="Profile Image" width="46" height="46"
                            style="border-radius: 9999px; object-fit: cover;">
                    </button>
                    <div class="popup-profile">
                        <p>{{ auth()->user() != null ? (auth()->user()->role == 'super_admin' ? 'admin' : auth()->user()->role) : 'Belum login' }}
                        </p>
                        <div class="profile-list d-flex flex-column" style="gap: 12px;">
                            <a href="{{ route('dashboard.index') }}" class="list-link d-flex gap-2 align-items-center">
                                <div class="dashboard-icon"></div>
                                Dashboard
                            </a>
                            <a href="{{ route('report-transaction') }}"
                                class="list-link d-flex gap-2 align-items-center">
                                <div class="history-icon"></div>
                                Riwayat Transaksi
                            </a>
                            <a href="{{ auth()->user()->role == 'customer' ? route('profile') : route('profile.index') }}"
                                class="list-link d-flex gap-2 align-items-center">
                                <div class="setting-icon"></div>
                                Pengaturan Akun
                            </a>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="button-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                <img src="{{ asset('assets/images/icons/logout.png') }}" alt="Logout Icon"
                                    width="16">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>
