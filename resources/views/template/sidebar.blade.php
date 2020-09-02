<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset("assets/dist/img/AdminLTELogo.png")}}" alt="SIGAV Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SIGAV APPS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset("assets/dist/img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">VRIZKI Technology</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dolly-flatbed"></i>
              <p>
                Transaksi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/transaksi" class="nav-link">
                  <i class="far fa-product nav-icon"></i>
                  <p>Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pengeluaran" class="nav-link">
                  <i class="far fa-category nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dolly-flatbed"></i>
              <p>
                Produk
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/produk" class="nav-link">
                  <i class="far fa-product nav-icon"></i>
                  <p>List Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/produk/kategori" class="nav-link">
                  <i class="far fa-category nav-icon"></i>
                  <p>Kategori Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/stok" class="nav-link">
                  <i class="far fa-category nav-icon"></i>
                  <p>Tambah Stok Barang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/produk/edit" class="nav-link">
                  <i class="far fa-category nav-icon"></i>
                  <p>Edit Barang</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/laporan/penjualan" class="nav-link">
                  <i class="far fa-credit-card nav-icon"></i>
                  <p>Laporan Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/laporan/keuangan" class="nav-link">
                  <i class="far fa-money-bill-alt nav-icon"></i>
                  <p>Laporan Keuangan</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
