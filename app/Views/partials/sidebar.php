<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <!--menu-->
                <li class="menu-title">Menu</li>

                <?php if(sess_activeRole() != 'Cashier'): ?>
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
                        <li><a href="<?= base_url('entitas-usaha-get-list') ?>">Data Entitas Usaha</a></li>
                        <li><a href="<?= base_url('item-get-list') ?>">Data Produk</a></li>
                        <li><a href="<?= base_url('satuan-get-list') ?>">Data Satuan</a></li>
                        <li><a href="<?= base_url('paymentMethod-get-list') ?>">Data Metode Bayar</a></li>
                        <li><a href="<?= base_url('distributionChanel-get-list') ?>">Data Chanel Distribusi</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-laptop"></i>
                        <span>POS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('transaksi-show-cashier') ?>">Kasir</a></li>
                        <li><a href="<?= base_url('transaksi-get-list') ?>">List Transaksi</a></li>
                        <li><a href="<?= base_url('cashdrawer-get-list') ?>">Cash Drawer</a></li>
                    </ul>
                </li>

                <?php if(sess_activeRole() != 'Cashier'): ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-archive"></i>
                        <span>Inventory</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= base_url('data-stock-get-list') ?>">Buffer Stok</a></li>
                        <li><a href="<?= base_url('data-transaksi-stock-get-list') ?>">Transaksi Stok</a></li>
                        <li><a href="<?= base_url('restock-get-list') ?>">Restock</a></li>
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
                    </ul>
                </li>
                <?php endif; ?>
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-alt"></i>
                        <span>Data User</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <?php if(sess_activeRole() != 'Cashier'): ?>
                        <li><a href="<?= base_url('user-get-list') ?>">List User</a></li>
                    <?php endif; ?>
                        <li><a href="<?= base_url('user-get-profile') ?>">Profil</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
