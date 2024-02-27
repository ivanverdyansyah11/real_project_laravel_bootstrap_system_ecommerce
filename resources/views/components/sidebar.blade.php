<div class="sidebar d-flex flex-column align-items-center">
    <img src="{{ asset('assets/images/brand/brand-logo.svg') }}" alt="Brand Logo" class="img-fluid" width="72" height="72" style="object-fit: cover;">
    <div class="sidebar-link w-100">
        <a href="{{ route('dashboard.index') }}" class="link-item d-flex align-items-center {{ Route::is('dashboard.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/dashboard.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Dashboard</span>
        </a>
        <a href="{{ route('profile.index') }}" class="link-item d-flex align-items-center d-lg-none {{ Route::is('profile.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/profile.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Profile</span>
        </a>
        <button id="data_user" type="button" class="link-item d-flex align-items-center {{ Route::is('reseller.index') || Route::is('customer.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/user.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Pengguna</span>
        </button>
        <div class="item-child {{ Route::is('reseller.index') || Route::is('customer.index') ? 'active' : '' }}" id="child_data_user">
            <a href="{{ route('reseller.index') }}" class="{{ Route::is('reseller.index') ? 'active' : '' }}">Karyawan</a>
            <a href="{{ route('customer.index') }}" class="{{ Route::is('customer.index') ? 'active' : '' }}">Pelanggan</a>
        </div>
        <a href="{{ route('cashier.index') }}" class="link-item d-flex align-items-center {{ Route::is('cashier.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/cashier.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Kasir</span>
        </a>
        <a href="{{ route('category.index') }}" class="link-item d-flex align-items-center {{ Route::is('category.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/category.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Kategori</span>
        </a>
        <a href="{{ route('product.index') }}" class="link-item d-flex align-items-center {{ Route::is('product.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/product.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Produk</span>
        </a>
        <a href="{{ route('package.index') }}" class="link-item d-flex align-items-center {{ Route::is('package.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/package.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Paket</span>
        </a>
        <a href="{{ route('reward.index') }}" class="link-item d-flex align-items-center {{ Route::is('reward.index') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/reward.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Penghargaan</span>
        </a>
        <button id="data_transaction" type="button" class="link-item d-flex align-items-center {{ Route::is('transaction-pending') || Route::is('transaction-finish') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/transaction.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Penjualan</span>
        </button>
        <div id="child_data_transaction" class="item-child {{ Route::is('transaction-pending') || Route::is('transaction-finish') ? 'active' : '' }}">
            <a href="{{ route('transaction-pending') }}" class="{{ Route::is('transaction-pending') ? 'active' : '' }}">Transaksi Tertunda</a>
            <a href="{{ route('transaction-finish') }}" class="{{ Route::is('transaction-finish') ? 'active' : '' }}">Transaksi Selesai</a>
        </div>
        <button id="data_report" type="button" class="link-item d-flex align-items-center {{ Route::is('report-reward.index') || Route::is('report-transaction') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/report.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Report Laporan</span>
        </button>
        <div id="child_data_report" class="item-child {{ Route::is('report-reward.index') || Route::is('report-transaction') ? 'active' : '' }}">
            <a href="{{ route('report-reward.index') }}" class="{{ Route::is('report-reward.index') ? 'active' : '' }}">Rekap Point</a>
            <a href="{{ route('report-transaction') }}" class="{{ Route::is('report-transaction') ? 'active' : '' }}">Rekap Transaksi</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="link-item d-flex align-items-center">
                <img src="{{ asset('assets/images/sidebar/logout.png') }}" alt="Sidebar Icon" class="img-fluid">
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
