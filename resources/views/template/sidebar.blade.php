<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/dashboard"
            target="_blank">
            <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Toko Agung Textile</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-dashcube {{ request()->is('dashboard') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Master Data</h6>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->is('kelompokCoa*') ? 'active' : '' }}" href="/kelompokCoa">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-th-large {{ request()->is('kelompokCoa*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kelompok COA</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('coa*') ? 'active' : '' }}" href="/coa">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-book {{ request()->is('coa*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">COA</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" href="/kategori">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-list {{ request()->is('kategori*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kategori</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('produk*') ? 'active' : '' }}" href="/produk">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-cubes {{ request()->is('produk*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Produk</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pelanggan*') ? 'active' : '' }}" href="/pelanggan">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-users {{ request()->is('pelanggan*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pelanggan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}" href="/supplier">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-truck {{ request()->is('supplier*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Transaksi</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}" href="/penjualan">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-book {{ request()->is('penjualan*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}" href="/pembelian">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-book {{ request()->is('pembelian*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pembelian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pengeluaran*') ? 'active' : '' }}" href="/pengeluaran">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-book {{ request()->is('pengeluaran*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pengeluaran</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('jurnalUmum*') ? 'active' : '' }}" href="/jurnalUmum">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-book {{ request()->is('jurnalUmum*') ? 'text-white' : 'text-muted' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Jurnal Umum</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
