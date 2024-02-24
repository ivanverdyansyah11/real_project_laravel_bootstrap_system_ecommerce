<div class="topbar d-flex align-items-center justify-content-between me-lg-4">
    <p class="topbar-title">{{ $title }}</p>
    <div class="topbar-profile d-flex align-items-center gap-2">
        <a href="{{ route('profile.index') }}" class="d-none d-lg-inline-block">
            <img src="{{ asset('assets/images/profile/profile-not-found.jpg') }}" alt="Profile Image" class="img-fluid" width="46" height="46" style="border-radius: 9999px; object-fit: cover;">
        </a>
        <div class="hamburger d-lg-none d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/images/icons/hamburger-list.png') }}" alt="Hamburger List" class="img-fluid" width="19">
        </div>
    </div>
</div>