<div class="sidebar d-flex flex-column align-items-center">
    <img src="{{ asset('assets/images/brand/brand-logo.svg') }}" alt="Brand Logo" class="img-fluid" width="72" height="72" style="object-fit: cover;">
    <div class="sidebar-link w-100">
        <a href="{{ route('dashboard') }}" class="link-item d-flex align-items-center {{ Route::is('dashboard') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/dashboard.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Dashboard</span>
        </a>
        <button id="data_user" type="button" class="link-item d-flex align-items-center {{ Route::is('reseller') || Route::is('customer') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/user.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Data User</span>
        </button>
        <div class="item-child {{ Route::is('reseller') || Route::is('customer') ? 'active' : '' }}" id="child_data_user">
            <a href="#" class="{{ Route::is('reseller') ? 'active' : '' }}">Karyawan</a>
            <a href="#" class="{{ Route::is('customer') ? 'active' : '' }}">Pelanggan</a>
        </div>
        <a href="{{ route('product') }}" class="link-item d-flex align-items-center {{ Route::is('product') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/product.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Produk</span>
        </a>
        <a href="{{ route('reward') }}" class="link-item d-flex align-items-center {{ Route::is('reward') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/reward.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Penghargaan</span>
        </a>
        <button id="data_transaction" type="button" class="link-item d-flex align-items-center {{ Route::is('transaction') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/transaction.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Penjualan</span>
        </button>
        <div class="item-child {{ Route::is('transaction') ? 'active' : '' }}" id="child_data_transaction">
            <a href="#" class="{{ Route::is('transaction') ? 'active' : '' }}">Transaksi Pesanan</a>
            <a href="#" class="{{ Route::is('transaction') ? 'active' : '' }}">Transaksi Selesai</a>
        </div>
        <button type="button" class="link-item d-flex align-items-center {{ Route::is('report-reward') || Route::is('report-transaction') ? 'active' : '' }}">
            <img src="{{ asset('assets/images/sidebar/report.png') }}" alt="Sidebar Icon" class="img-fluid">
            <span>Report Laporan</span>
        </button>
        <div class="item-child {{ Route::is('report-reward') || Route::is('report-transaction') ? 'active' : '' }}">
            <a href="#" class="{{ Route::is('report-reward') || Route::is('report-transaction') ? 'active' : '' }}">Rekap Point</a>
            <a href="#" class="{{ Route::is('report-reward') || Route::is('report-transaction') ? 'active' : '' }}">Rekap Transaksi</a>
        </div>
    </div>
</div>