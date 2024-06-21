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
                            </div>
                        </div>

                        <!-- row 1 -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <!-- total penjualan -->
                                    <div class="col-md-4">
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
                                    <!-- total keuntungan bersih -->
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1 overflow-hidden">
                                                        <p class="text-truncate font-size-14 mb-2">Profit Bersih</p>
                                                        <h4 id="profit_bersih" class="mb-0">
                                                            Rp 
                                                            <?= thousand_separator($transaction_data[0]->total_nominal - $transaction_data[0]->total_hpp) - $cashdrawer_data[0]->total_credfit ?>
                                                        </h4>
                                                    </div>
                                                    <div class="text-primary ms-auto">
                                                        <i class="ri-folder-received-line font-size-24"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- total transaksi -->
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1 overflow-hidden">
                                                        <p class="text-truncate font-size-14 mb-2">Jumlah Transaksi</p>
                                                        <h4 id="total_transaksi" class="mb-0">
                                                            <?= thousand_separator($transaction_data[0]->total_transaksi) ?>
                                                        </h4>
                                                    </div>
                                                    <div class="text-primary ms-auto">
                                                        <i class="ri-file-paper-2-line font-size-24"></i>
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
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Top 5 Produk/Treatment</h4>
                                                
                                        <div id="donut_chart" class="apex-charts"  dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        

                                        <h4 class="card-title mb-3">Stok Terendah</h4>

                                        <div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-hover mb-0 table-centered table-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 60px;">
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title rounded-circle bg-light">
                                                                        <img src="assets/images/companies/img-1.png" alt="img-1" height="20">
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <h5 class="font-size-14 mb-0">Facial Korea Carboxy CO2</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">10</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title rounded-circle bg-light">
                                                                        <img src="assets/images/companies/img-2.png" alt="img-2" height="20">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-14 mb-0">Skin Booster Vitaran</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">8</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title rounded-circle bg-light">
                                                                        <img src="assets/images/companies/img-3.png" alt="img-3" height="20">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-14 mb-0">Facial Kromosom (Fire&Ice)</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">7</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title rounded-circle bg-light">
                                                                        <img src="assets/images/companies/img-3.png" alt="img-4" height="20">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-14 mb-0">Facial Kromosom (Fire&Ice)</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">7</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title rounded-circle bg-light">
                                                                        <img src="assets/images/companies/img-3.png" alt="img-5" height="20">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-14 mb-0">Facial Kromosom (Fire&Ice)</h5>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">7</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Top 5 Customer</h4>
                                                
                                        <div id="pie_chart" class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                            </div>   
                        </div>
                        <!-- end row 2 -->

                        <!-- start row 3 -->    
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        

                                        <h4 class="card-title mb-4">Transaksi Hari Ini</h4>

                                        <div class="table-responsive">
                                            <table class="table table-centered datatable dt-responsive nowrap" data-bs-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck">
                                                                <label class="form-check-label mb-0" for="ordercheck">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th>Order ID</th>
                                                        <th>Date</th>
                                                        <th>Billing Name</th>
                                                        <th>Total</th>
                                                        <th>Payment Status</th>
                                                        <th style="width: 120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck1">
                                                                <label class="form-check-label mb-0" for="ordercheck1">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1572</a> </td>
                                                        <td>
                                                            04 Apr, 2020
                                                        </td>
                                                        <td>Walter Brown</td>

                                                        <td>
                                                            $172
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Paid</div>
                                                        </td>
                                                        <td id="tooltip-container1">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck2">
                                                                <label class="form-check-label mb-0" for="ordercheck2">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1571</a> </td>
                                                        <td>
                                                            03 Apr, 2020
                                                        </td>
                                                        <td>Jimmy Barker</td>

                                                        <td>
                                                            $165
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-warning font-size-12">unpaid</div>
                                                        </td>
                                                        <td id="tooltip-container2">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck3">
                                                                <label class="form-check-label mb-0" for="ordercheck3">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1570</a> </td>
                                                        <td>
                                                            03 Apr, 2020
                                                        </td>
                                                        <td>Donald Bailey</td>

                                                        <td>
                                                            $146
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Paid</div>
                                                        </td>
                                                        <td id="tooltip-container3">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck4">
                                                                <label class="form-check-label mb-0" for="ordercheck4">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1569</a> </td>
                                                        <td>
                                                            02 Apr, 2020
                                                        </td>
                                                        <td>Paul Jones</td>

                                                        <td>
                                                            $183
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Paid</div>
                                                        </td>
                                                        <td id="tooltip-container41">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container41" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container41" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck5">
                                                                <label class="form-check-label mb-0" for="ordercheck5">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1568</a> </td>
                                                        <td>
                                                            01 Apr, 2020
                                                        </td>
                                                        <td>Jefferson Allen</td>

                                                        <td>
                                                            $160
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-danger font-size-12">Chargeback</div>
                                                        </td>
                                                        <td id="tooltip-container4">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container4" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container4" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck6">
                                                                <label class="form-check-label mb-0" for="ordercheck6">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1567</a> </td>
                                                        <td>
                                                            31 Mar, 2020
                                                        </td>
                                                        <td>Jeffrey Waltz</td>

                                                        <td>
                                                            $105
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-warning font-size-12">unpaid</div>
                                                        </td>
                                                        <td id="tooltip-container5">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container5" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container5" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck7">
                                                                <label class="form-check-label mb-0" for="ordercheck7">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1566</a> </td>
                                                        <td>
                                                            30 Mar, 2020
                                                        </td>
                                                        <td>Jewel Buckley</td>

                                                        <td>
                                                            $112
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Paid</div>
                                                        </td>
                                                        <td id="tooltip-container6">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container6" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container6" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck8">
                                                                <label class="form-check-label mb-0" for="ordercheck8">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1565</a> </td>
                                                        <td>
                                                            29 Mar, 2020
                                                        </td>
                                                        <td>Jamison Clark</td>

                                                        <td>
                                                            $123
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Paid</div>
                                                        </td>
                                                        <td id="tooltip-container7">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container7" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container7" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck9">
                                                                <label class="form-check-label mb-0" for="ordercheck9">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1564</a> </td>
                                                        <td>
                                                            28 Mar, 2020
                                                        </td>
                                                        <td>Eddy Torres</td>

                                                        <td>
                                                            $141
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-success font-size-12">Paid</div>
                                                        </td>
                                                        <td id="tooltip-container8">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container8" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container8" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="ordercheck10">
                                                                <label class="form-check-label mb-0" for="ordercheck10">&nbsp;</label>
                                                            </div>
                                                        </td>

                                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">#NZ1563</a> </td>
                                                        <td>
                                                            28 Mar, 2020
                                                        </td>
                                                        <td>Frank Dean</td>

                                                        <td>
                                                            $164
                                                        </td>
                                                        <td>
                                                            <div class="badge badge-soft-warning font-size-12">unpaid</div>
                                                        </td>
                                                        <td id="tooltip-container9">
                                                            <a href="javascript:void(0);" class="me-3 text-primary" data-bs-container="#tooltip-container9" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger" data-bs-container="#tooltip-container9" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row 3-->
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
    
</script>
