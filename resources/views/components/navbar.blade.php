<nav class="navbar navbar-expand-lg bg-body-tertiary py-2">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="{{ route('homepage') }}">
            <img src="{{ asset('assets/images/brand/brand-logo.svg') }}" alt="Brand Logo" width="56">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link {{ Route::is('homepage') ? 'active' : '' }}" href="{{ route('homepage') }}">Beranda</a>
                <a class="nav-link {{ Route::is('products') ? 'active' : '' }}" href="{{ route('products') }}">Produk</a>
                <a class="nav-link {{ Route::is('testimonial') ? 'active' : '' }}" href="{{ route('testimonial') }}">Testimoni</a>
                <a class="nav-link {{ Route::is('cart*') ? 'active' : '' }}" href="{{ route('cart.index') }}">Keranjang</a>
                {{-- <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a> --}}
            </div>
        </div>
        <a href="{{ auth()->user()->role == 'customer' ? route('profile') : route('profile.index') }}" class="d-none d-lg-inline-block">
            <img src="{{ file_exists('assets/images/profile/' . auth()->user()->image) && auth()->user()->image ? asset('assets/images/profile/' . auth()->user()->image) : asset('assets/images/profile/profile-not-found.jpg') }}" alt="Profile Image" width="46" height="46" style="border-radius: 9999px; object-fit: cover;">
        </a>
    </div>
</nav>
