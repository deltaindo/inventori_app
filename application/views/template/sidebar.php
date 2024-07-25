<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="menu-icon mdi mdi-account-key"></i>
        <span class="menu-title">
          Auth System
        </span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/admin'); ?>">
              List Admin
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#master_pengguna" aria-expanded="false" aria-controls="master_pengguna">
        <i class="menu-icon mdi mdi-database"></i>
        <span class="menu-title">
          Master Pengguna
        </span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="master_pengguna">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_divisi'); ?>">
              Master Divisi
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_karyawan'); ?>">
              Master Karyawan
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#master" aria-expanded="false" aria-controls="master">
        <i class="menu-icon mdi mdi-database"></i>
        <span class="menu-title">
          Master Assets
        </span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="master">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_kantor'); ?>">
              Master Kantor
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_lokasi'); ?>">
              Master Lokasi
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_barang'); ?>">
              Master Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_satuan'); ?>">
              Master Satuan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_merek'); ?>">
              Master Merek
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/master_kategori'); ?>">
              Master Kategori
            </a>
          </li>
    </li>
  </ul>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#form-penjualan" aria-expanded="false" aria-controls="form-penjualan">
      <i class="menu-icon mdi mdi-truck-delivery"></i>
      <span class="menu-title">
        Transaksi
      </span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="form-penjualan">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/jurnal_barang'); ?>">
            Jurnal Barang
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/jurnal_masuk_barang'); ?>">
            Jurnal Barang Masuk
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/barang_masuk'); ?>">
            Barang Masuk
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/barang_keluar'); ?>">
            Barang Keluar
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/peminjaman'); ?>">
            Peminjaman
          </a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#inventaris" aria-expanded="false" aria-controls="inventaris">
      <i class="menu-icon mdi mdi-calendar-multiple-check"></i>
      <span class="menu-title">
        Inventaris
      </span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="inventaris">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/jurnal_inventaris_barang'); ?>">
            Jurnal Inventaris Barang
          </a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">
      <i class="menu-icon mdi mdi-folder-open"></i>
      <span class="menu-title">
        Report
      </span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="report">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/report_stok_barang'); ?>">
            Jurnal Stok Barang
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/report_history_inventaris'); ?>">
            Jurnal History Inventaris
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/report_assets_inventaris'); ?>">
            Jurnal Assets Inventaris
          </a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#form-produk" aria-expanded="false" aria-controls="form-produk">
      <i class="menu-icon mdi mdi-package-variant-closed"></i>
      <span class="menu-title">
        Produk
      </span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="form-produk">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/perlengkapan_kantor'); ?>">
            Inventaris
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/daftar_produk'); ?>">
            Pralatan Praktek
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/daftar_laptop'); ?>">
            Daftar Laptop
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard/perlengkapan_peserta'); ?>">
            Perlengkapan Peserta & ATK
          </a>
        </li>

        <li class="nav-item d-none">
          <a class="nav-link" href="tambah_produk.html">
            Tambah Produk
          </a>
        </li>
        <li class="nav-item d-none">
          <a class="nav-link" href="rincian.html">
            rincian
          </a>
        </li>
        <li class="nav-item d-none">
          <a class="nav-link" href="edit_produk.html">
            edit
          </a>
        </li>
      </ul>
    </div>
  </li>


  <li class="nav-item nav-category">
    User
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
      <i class="menu-icon mdi mdi-account-circle-outline"></i>
      <span class="menu-title">
        User Pages
      </span>
      <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="user">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="#">
            Profil Saya
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
            Keluar
          </a>
        </li>
      </ul>
    </div>
  </li>
  </ul>
</nav>