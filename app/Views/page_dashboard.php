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

                        <!-- filter -->
                        <form method="post" action="<?= base_url('dashboard/index') ?>">
                            <div class="row">
                                <div class="col-lg-3 mb-3">
                                    <label for="filterDateFrom">Dari Tanggal</label>
                                    <div class="input-group" id="datepicker2">
                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                            data-date-autoclose="true" id="filterDateFrom" name="filterDateFrom" value="<?= $filter_from_date ?>">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="filterDateUntil">Sampai Tanggal</label>
                                    <div class="input-group" id="datepicker2">
                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                            data-date-autoclose="true" id="filterDateUntil" name="filterDateUntil" value="<?= $filter_to_date ?>">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-5">
                                    <label class="text-light">_</label>
                                    <div>
                                        <button type="submit" class="btn btn-dark ml-3">Filter</button>
                                        <button type="button" class="btn btn-danger ml-3" onclick="resetFilter()">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">Rekap Penjualan Produk</h4>
                                                <div id="chart_penjualan_produk" class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">


                                                <h4 class="card-title mb-3">Top 5 Produk</h4>

                                                <div>
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-hover mb-0 table-centered table-nowrap">
                                                            <tbody>
                                                                <?php foreach ($most_product as $list): ?>
                                                                    <tr>
                                                                        <td style="width: 60px;">
                                                                            <div class="avatar-xs">
                                                                                <div class="avatar-title rounded-circle bg-light">
                                                                                    <img src="<?= base_url('upload/item_pict/' . $list->image_filename); ?>" alt="img-1" height="30">
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <h5 class="font-size-14 mb-0"><?= $list->nama_item ?></h5>
                                                                        </td>
                                                                        <td>
                                                                            <p class="text-muted mb-0"><?= thousand_separator($list->total_sell) ?></p>
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
                                <!-- Revenue Analytics -->
                            </div>


                        </div>
                        <!-- end row -->

                    </div>

                </div>
                <!-- End Page-content -->

                <?= $this->include('partials/footer') ?>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

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

    function resetFilter() {
        document.getElementById('filterDateFrom').value = '<?= $current_date ?>';
        document.getElementById('filterDateUntil').value = '<?= $current_date ?>';
        document.forms[0].submit();
    }

    // chart rekap penjualan produk
    $(document).ready(function () {
        $.ajax({
            url: "<?php echo site_url('dashboard/getMostProductData'); ?>",
            method: "GET",
            dataType: "json",
            data: {
                filterDateFrom: $('#filterDateFrom').val(),
                filterDateUntil: $('#filterDateUntil').val()
            },
            success: function (response) {
                var seriesData = response.map(item => item.y); // Quantities
                var labelsData = response.map(item => item.name); // Product names

                var options = {
                    chart: {
                        height: 320,
                        type: 'pie',
                    },
                    series: seriesData,
                    labels: labelsData,
                    colors: [
                        "#1cbb8c", "#5664d2", "#fcb92c", "#4aa3ff", "#ff3d60", 
                        "#9a5ab5", "#ff8533", "#33ccff", "#70db70", "#cc0066", 
                        "#ff9933", "#9933ff", "#ff66cc", "#66ff99", "#ff3333"
                    ],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        verticalAlign: 'middle',
                        floating: false,
                        fontSize: '14px',
                        offsetX: 0,
                        offsetY: 5
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: false
                            },
                        }
                    }]
                };

                var chart = new ApexCharts(
                    document.querySelector("#chart_penjualan_produk"),
                    options
                );

                chart.render();
            },
            error: function (xhr, status, error) {
                console.error("Failed to fetch pie chart data:", error);
            }
        });
    });

</script>
