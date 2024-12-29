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
                        <!-- end page title -->

                        <!-- filter  -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-secondary text-light">
                                    <div class="card-body">
                                        <h5 class="mb-3 text-light">Filter</h5>
                                        <form id="form-filter">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <label for="filter_date_from" class="form-label">Dari Tanggal</label>
                                                    <input type="date" class="form-control" id="filter_date_from" name="filter_date_from">
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label for="filter_date_until" class="form-label">Hingga Tanggal</label>
                                                    <input type="date" class="form-control" id="filter_date_until" name="filter_date_until">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-12" style="text-align: right">
                                                    <a id="btn_reset" class="btn btn-danger ml-3"> Reset </a>
                                                    <button id="btn_filter" class="btn btn-dark ml-3"> Filter </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <div class="table-responsive"> -->
                                            <table id="main_table" class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                    <th class="text-center">No.</th>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">Nama Produk</th>
                                                        <th class="text-center">Jumlah Terjual</th>
                                                        <th class="text-center">Total Penjualan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table rows will be added dynamically -->
                                                </tbody>
                                            </table>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <?= $this->include('partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

       
        <!-- JAVASCRIPT -->
        <?= $this->include('partials/vendor-scripts') ?>
        <?= $this->include('partials/custom-page-scripts') ?>

    </body>
</html>

<script>
    // var
    const baseUrl = "<?= base_url() ?>";
    var mainTable;

    // Call the function when the document is ready
    $(document).ready(function() {
        mainDatatable();
    });

    // Initialize or reinitialize the DataTable
    function mainDatatable() {
        // Destroy the existing DataTable instance if it exists
        if (mainTable) {
            mainTable.destroy();
        }

        // Initialize the DataTable
        mainTable = $('#main_table').DataTable({
		    "processing": true,
            "serverSide": true,
            "scrollX": true,
            "autoWidth": false,
            // "responsive": true,
			language: {
				"paginate": {
					"first":      "&laquo",
					"last":       "&raquo",
					"next":       "&gt",
					"previous":   "&lt"
				},
			},
            lengthMenu: [ 
                [10, 25, 50, 100, -1],
                ['10', '25', '50', '100', 'ALL']
            ],
            ajax: {
                "url": "<?php echo site_url('laporan/ajaxGetReportByProduct')?>",
                "type": "POST",
                "data": function ( data ) {
                    data.searchValue = $('#main_table_filter input').val();
                    data.filterDateFrom = $('#filter_date_from').val();
                    data.filterDateUntil = $('#filter_date_until').val();
                },
                "dataSrc": function (returnedData) {                    
                    return returnedData.data;
                }
            },
            columnDefs: [
                { 
                "targets": [ 0, 1, 2, 3, 4 ],
                "className": "text-center"
                },
                { 
                    "targets": [ 0, 4 ],
                    "orderable": false,
                },
            ],
		});
    }

    // btn filter
    $('#btn_filter').on('click', function (e) {
        e.preventDefault();
        mainDatatable();
    });

    // btn reset
    $('#btn_reset').on('click', function (e) {
        e.preventDefault();
        
        // Clear the filter inputs
        $('#filter_date_from').val('');
        $('#filter_date_until').val('');
        
        // Redraw the table with cleared filters
        mainDatatable();
    });

</script>
