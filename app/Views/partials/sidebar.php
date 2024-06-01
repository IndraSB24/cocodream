<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <!--menu-->
                <li class="menu-title">Menu</li>

                <li>
                    <a href="<?= base_url('dashboard-show') ?>" class="waves-effect">
                        <i class="fas fa-chalkboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-book-open"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('pasien-get-list') ?>">Data Pasien</a></li>
                        <li><a href="<?= base_url('karyawan-get-list') ?>">Data Karyawan</a></li>
                        <li><a href="<?= base_url('vendor-get-list') ?>">Data Vendor</a></li>
                        <li><a href="<?= base_url('entitas-usaha-get-list') ?>">Data Entitas Usaha</a></li>
                        <li><a href="<?= base_url('item-get-list') ?>">Data Produk</a></li>
                        <li><a href="<?= base_url('satuan-get-list') ?>">Data Satuan</a></li>
                        <li><a href="<?= base_url('jenis-item-get-list') ?>">Data Jenis Item</a></li>
                        <li><a href="<?= base_url('kategori-item-get-list') ?>">Data Kategori Item</a></li>
                        <li><a href="<?= base_url('brand-get-list') ?>">Data Brand</a></li>
                    </ul>

                </li>

                <li>
                    <a href="<?= base_url('registrasi-get-list') ?>" class="waves-effect">
                        <i class="fas fa-address-card"></i>
                        <span>Registrasi</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-laptop"></i>
                        <span>POS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('transaksi-get-list') ?>">Kasir</a></li>
                        <li><a href="<?= base_url('cashdrawer-get-list') ?>">Cash Drawer</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url('emr-show-list') ?>" class="waves-effect">
                        <i class="fas fa-book-medical"></i>
                        <span>MR</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-archive"></i>
                        <span>Inventory</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('data-stock-get-list') ?>">Buffer Stok</a></li>
                        <li><a href="<?= base_url('data-transaksi-stock-get-list') ?>">Transaksi Stok</a></li>
                        <li><a href="<?= base_url('stock-management-get-list') ?>">Managemen Stok</a></li>
                        <li><a href="<?= base_url('stock-opname-get-list') ?>">Stok Opname</a></li>
                        
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-people-arrows"></i>
                        <span>HRM</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('hrm-show-absensi') ?>">Absensi</a></li>
                        <li><a href="<?= base_url('hrm-show-absensi-list/null') ?>">Rekap Absensi</a></li>
                        <li><a href="<?= base_url('hrm-show-scheduling') ?>">Scheduling</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-balance-scale-right"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('laporanpenjualan-show') ?>">Laporan Penjualan</a></li>
                        <li><a href="<?= base_url('cashdrawer-get-list') ?>">Laporan Pengeluaran</a></li>
                        <li><a href="<?= base_url('cashdrawer-get-list') ?>">Laporan Stok</a></li>
                        <li><a href="<?= base_url('cashdrawer-get-list') ?>">Laporan Karyawan</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-alt"></i>
                        <span>Data User</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('user-get-list') ?>">List User</a></li>
                        <li><a href="<?= base_url('user-get-profile') ?>">Profil</a></li>
                    </ul>
                </li>

                
                <!--page-->
                <li class="menu-title"><?= lang('Files.Pages') ?></li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span><?= lang('Files.Authentication') ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login"><?= lang('Files.Login') ?></a></li>
                        <li><a href="auth-register"><?= lang('Files.Register') ?></a></li>
                        <li><a href="auth-recoverpw"><?= lang('Files.Recover_Password') ?></a></li>
                        <li><a href="auth-lock-screen"><?= lang('Files.Lock_Screen') ?></a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
