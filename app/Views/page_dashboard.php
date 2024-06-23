<?= $this->include('partials/main') ?>

    <head>

        <?= $title_meta ?>

        <?= $this->include('partials/custom-css') ?>
        <?= $this->include('partials/head-css') ?>

    </head>

    <?= $this->include('partials/body') ?>

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?= $this->include('partials/menu') ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <?= $page_title ?>

                        <!-- filter  -->
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                
                            </div>
                        </div>

                        <!-- row 1 -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <!-- total penjualan -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1 overflow-hidden">
                                                        <p class="text-truncate font-size-14 mb-2">Total Penjualan</p>
                                                        <h4 id="total_penjualan" class="mb-0">
                                                            Rp. <?= thousand_separator($transaction_data[0]->total_nominal) ?>
                                                        </h4>
                                                    </div>
                                                    <div class="text-primary ms-auto">
                                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- total hpp -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1 overflow-hidden">
                                                        <p class="text-truncate font-size-14 mb-2">Total HPP</p>
                                                        <h4 id="total_hpp" class="mb-0">
                                                            Rp <?= thousand_separator($transaction_data[0]->total_hpp) ?>
                                                        </h4>
                                                    </div>
                                                    <div class="text-primary ms-auto">
                                                        <i class="ri-file-paper-2-line font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- total pengeluaran -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1 overflow-hidden">
                                                        <p class="text-truncate font-size-14 mb-2">Total Pengeluaran</p>
                                                        <h4 id="total_pengeluaran" class="mb-0">
                                                            Rp <?= thousand_separator($cashdrawer_data[0]->total_credit) ?>
                                                        </h4>
                                                    </div>
                                                    <div class="text-primary ms-auto">
                                                        <i class="ri-file-paper-2-line font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- total keuntungan bersih -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1 overflow-hidden">
                                                        <p class="text-truncate font-size-14 mb-2">Profit Bersih</p>
                                                        <h4 id="profit_bersih" class="mb-0">
                                                            Rp 
                                                            <?= thousand_separator($transaction_data[0]->total_nominal - $transaction_data[0]->total_hpp - $cashdrawer_data[0]->total_credit) ?>
                                                        </h4>
                                                    </div>
                                                    <div class="text-primary ms-auto">
                                                        <i class="ri-folder-received-line font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                                <!-- end row -->


                                <!-- Revenue Analytics -->
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="card-title mb-4">Grafik Penjualan</h4>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Filter
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <a class="dropdown-item" href="#">Hari</a>
                                                <a class="dropdown-item" href="#">Bulan</a>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="line-column-chart" class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div>

                                    
                                </div>
                                <!-- Revenue Analytics -->
                            </div>

                            
                        </div>
                        <!-- end row -->
                        
                        <!-- start row 2 -->
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        

                                        <h4 class="card-title mb-3">Top 5 Produk</h4>

                                        <div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover mb-0 table-centered table-nowrap">
                                                    <tbody>
                                                        <?php foreach($most_product as $list): ?>
                                                            <tr>
                                                                <td style="width: 60px;">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light">
                                                                            <img src="assets/images/companies/img-1.png" alt="img-1" height="20">
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <h5 class="font-size-14 mb-0">Jelly Mixfruit</h5>
                                                                </td>
                                                                <td>
                                                                    <p class="text-muted mb-0">10</p>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row 2 -->
                    </div>

                </div>
                <!-- End Page-content -->

                <?= $this->include('partials/footer') ?>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- apexcharts init -->
        <script src="assets/js/pages/apexcharts.init.js"></script>

        <!-- jquery.vectormap map -->
        <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <script src="assets/js/pages/dashboard.init.js"></script>
        <?= $this->include('partials/vendor-scripts') ?>
        <?= $this->include('partials/custom-page-scripts') ?>

    </body>

</html>

<script>
    
    console.log(<?= json_encode($transaction_data) ?>, 'TRANSACTION DATA');
    console.log(<?= json_encode($cashdrawer_data) ?>, 'CASH DRAWER DATA');
    console.log(<?= json_encode($most_product) ?>, 'MOST PRODUCT DATA');
    
</script>
