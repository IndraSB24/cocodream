<?= $this->include('partials/main') ?>

    <head>
        
        <?= $title_meta ?>

        <!-- DataTables -->
        <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     

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
                                                <div class="col-lg-4 mb-3">
                                                    <label for="filter_gender" class="form-label">Gender</label>
                                                    <select class="form-control select2" data-trigger name="filter_gender" id="filter_gender">
                                                        <option value="">Pilih Gender</option>
                                                        <option value="1">Laki-Laki</option>
                                                        <option value="2">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="filter_provinsi" class="form-label">Provinsi</label>
                                                    <select class="form-control select2" data-trigger name="filter_provinsi" id="filter_provinsi">
                                                        <option value="">Pilih Provinsi</option>
                                                        <?php
                                                            foreach($list_provinsi as $row){
                                                                echo '
                                                                    <option value="'.$row->id.'"> '.
                                                                        $row->nama.
                                                                    '</option>
                                                                ';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 mb-3">
                                                    <label for="filter_kota" class="form-label">kota</label>
                                                    <select class="form-control select2" data-trigger name="filter_kota" id="filter_kota">
                                                        <option value="">Pilih Kota</option>
                                                        <?php
                                                            foreach($list_kota as $row){
                                                                echo '
                                                                    <option value="'.$row->id.'"> '.
                                                                        $row->nama.
                                                                    '</option>
                                                                ';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-12" style="text-align: right">
                                                    <a class="btn btn-danger ml-3" onClick="reloadPage()"> Reset </a>
                                                    <button type="submit" class="btn btn-dark ml-3"> Filter </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add"> Tambah Data </button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="table_pasien" class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Kode Pasien</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Tanggal Lahir</th>
                                                        <th class="text-center">Alamat</th>
                                                        <th class="text-center">No Handphone</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table rows will be added dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <?= $this->include('partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- modal add -->
<div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form_modal_add" method="POST">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="name" class="form-label">Nama Pasien</label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="Nama Pasien" />
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="name" class="form-label">Tanggal Lahir</label>
                            <input class="form-control" type="date" id="tanggallahir" name="tanggallahir" placeholder="Tanggal Lahir" />
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="name" class="form-label">Alamat</label>
                            <input class="form-control" type="text" id="alamat" name="alamat" placeholder="Alamat" />
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="name" class="form-label">No Hp</label>
                            <input class="form-control" type="text" id="nohp" name="nohp" placeholder="No Hp" />
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="name" class="form-label">Kode Pasien</label>
                            <input class="form-control" type="text" id="kodepasien" name="kodepasien" placeholder="Kode Pasien" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right">
                            <button type="button" class="btn btn-primary ml-3" id="btn-simpan" data-object="<?= base_url('customer/add/customer') ?>">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Right Sidebar -->
        <?= $this->include('partials/right-sidebar') ?>

        <!-- JAVASCRIPT -->
        <?= $this->include('partials/vendor-scripts') ?>

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/jszip/jszip.min.js"></script>
        <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <script src="assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <script src="assets/libs/select2/js/select2.min.js"></script>
        <script src="assets/js/pages/form-advanced.init.js"></script>

        <!-- Datatable init js -->
        <script src="assets/js/pages/datatables.init.js"></script>

        <script src="assets/js/app.js"></script>

    </body>
</html>

<script>
    // var
    const baseUrl = "<?= base_url() ?>";

    // data table loader
    $(document).ready( function () {
		$('#table_pasien').DataTable({
		    "processing": true,
            "serverSide": true,
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
                "url": "<?php echo site_url('pasien/ajax_get/list_pasien')?>",
                "type": "POST",
                "data": function ( data ) {
                    data.searchValue = $('#table_pasien_filter input').val();
                }
            },
            columnDefs: [
                { 
                "targets": [ 0, 1, 3, 5 ],
                "className": "text-center"
                },
                { 
                    "targets": [ 0, 6 ],
                    "orderable": false,
                },
            ],
		});
	});

    // delete customer 
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = thisData['path'];
        const data = {
            id : thisData['id']
        };
        
        loadSaveSwal(
            path, data, 'Hapus Pasien Dengan Nama: '+thisData['nama']+' ?', 
            'Dihapus!', 'Pasien dengan Nama: '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // swall loader
    function loadSaveSwal(path, data, title1, title2, text2, modalToHide="") {
        Swal.fire({
            title: title1,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.value) {
                $.post(path, data, function (response) {
                    Swal.fire({
                        title: title2,
                        icon: 'success',
                        text: text2,
                        timer: 1000,
                        confirmButtonColor: "#5664d2",
                        onBeforeOpen: function () {
                            timerInterval = setInterval(function () {
                                Swal.getContent().querySelector('strong')
                                    .textContent = Swal.getTimerLeft();
                            }, 100);
                        }
                    }).then((result) => {
                        if(modalToHide!==""){
                            $('#'+modalToHide).modal('hide');   
                        }
                        reloadMainDatatable();
                    });
                }, 'json');
            }
        });
    }

</script>
