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

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add"> Tambah Vendor </button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <div class="table-responsive"> -->
                                            <table id="main_table" class="table table-bordered nowrap" 
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Kode Vendor</th>
                                                        <th class="text-center">Nama Vendor</th>
                                                        <th class="text-center">Tipe</th>
                                                        <th class="text-center">Alamat</th>
                                                        <th class="text-center">Kota</th>
                                                        <th class="text-center">Email</th>
                                                        <th class="text-center">No Hp 1</th>
                                                        <th class="text-center">No Hp 2</th>
                                                        <th class="text-center">Action</th>
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
        <div id="modal_add" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="kode" class="form-label">Kode Vendor</label>
                                    <input class="form-control" type="text" id="kode" name="kode" placeholder="Kode Vendor" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="nama" class="form-label">Nama Vendor</label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama Vendor" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tipe" class="form-label">Tipe Vendor</label>
                                    <input class="form-control" type="text" id="tipe" name="tipe" value="Supplier" readonly />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input class="form-control" type="text" id="alamat" name="alamat" placeholder="Alamat" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <select class="form-control select2" data-trigger name="kota" id="kota">
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
                                <div class="col-lg-12 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" name="email" placeholder="Email" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="phone_1" class="form-label">No Hp 1</label>
                                    <input class="form-control num-only" type="text" id="phone_1" name="phone_1" placeholder="No Hp 1" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="phone_2" class="form-label">No Hp 2</label>
                                    <input class="form-control num-only" type="text" id="phone_2" name="phone_2" placeholder="No Hp 2" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_simpan" 
                                        data-path="<?= base_url('vendor/add/vendor') ?>"
                                    >
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal edit -->
        <div id="modal_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="kode_vendor_edit" class="form-label">Kode Vendor</label>
                                    <input class="form-control" type="text" id="kode_vendor_edit" name="kode_vendor_edit" placeholder="Kode Vendor" />
                                    <input type="hidden" id="edit_id" name="edit_id" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="nama_edit" class="form-label">Nama Vendor</label>
                                    <input class="form-control" type="text" id="nama_edit" name="nama_edit" placeholder="Nama Vendor" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tipe_edit" class="form-label">Tipe Vendor</label>
                                    <input class="form-control" type="text" id="tipe_edit" name="tipe_edit" value="Supplier" readonly />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="alamat_edit" class="form-label">Alamat</label>
                                    <input class="form-control" type="text" id="alamat_edit" name="alamat_edit" placeholder="Alamat" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="kota_edit" class="form-label">Kota</label>
                                    <select class="form-control select2" data-trigger name="kota_edit" id="kota_edit">
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
                                <div class="col-lg-12 mb-3">
                                    <label for="email_edit" class="form-label">Email</label>
                                    <input class="form-control" type="text" id="email_edit" name="email_edit" placeholder="Email" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="no_hp_1_edit" class="form-label">No Hp 1</label>
                                    <input class="form-control num-only" type="text" id="no_hp_1_edit" name="no_hp_1_edit" placeholder="No Hp 1" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="no_hp_2_edit" class="form-label">No Hp 2</label>
                                    <input class="form-control num-only" type="text" id="no_hp_2_edit" name="no_hp_2_edit" placeholder="No Hp 2" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit" 
                                        data-path="<?= base_url('vendor/edit/vendor') ?>"
                                    >
                                        Konfirmasi Edit
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
            language: {
                "paginate": {
                    "first": "&laquo",
                    "last": "&raquo",
                    "next": "&gt",
                    "previous": "&lt"
                },
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10', '25', '50', '100', 'ALL']
            ],
            ajax: {
                "url": "<?= site_url('vendors/ajax_get_list_vendor') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3, 5 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 5 ],
                    "orderable": false,
                },
            ],
        });
    }

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('vendors/add') ?>";
        const data = {
            kode: $('#kode').val(),
            nama: $('#nama').val(),
            tipe: $('#tipe').val(),
            alamat: $('#alamat').val(),
            kota: $('#kota').val(),
            email: $('#email').val(),
            phone_1: $('#phone_1').val(),
            phone_2: $('#phone_2').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Simpan Vendor dengan nama: '+$('#nama').val()+' ?', 
            'Disimpan!', 'Vendor dengan nama: '+$('#nama').val()+' berhasil disimpan.', 'modal_add'
        );
    });

    // delete
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('vendors/delete') ?>";
        const data = {
            id : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus Satuan dengan nama: '+thisData['nama']+' ?', 
            'Dihapus!', 'Satuan dengan nama: '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit', function() {
        var idVendor = $(this).data('id');
        const path = "<?= site_url('vendors/ajax_get_vendor_data') ?>";
        
        $.ajax({
            url: path,
            method: 'POST',
            data: { id_vendor: idVendor },
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#edit_id').val(idVendor);
                $('#kode_vendor_edit').val(response.kode);
                $('#nama_edit').val(response.nama);
                $('#tipe_edit').val(response.tipe);
                $('#alamat_edit').val(response.alamat);
                $('#kota_edit').val(response.id_kota).trigger('change');
                $('#email_edit').val(response.email);
                $('#no_hp_1_edit').val(response.phone_1);
                $('#no_hp_2_edit').val(response.phone_2);
                
                // Show the modal
                $('#modal_edit').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    });

    // konfirmasi edit
    $(document).on('click', '#btn_konfirmasi_edit', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('vendors/edit') ?>";
        const data = {
            id_edit: $('#edit_id').val(),
            nama: $('#nama_edit').val(),
            tipe: $('#tipe_edit').val(),
            alamat: $('#alamat_edit').val(),
            id_kota: $('#kota_edit').val(),
            email: $('#email_edit').val(),
            phone_1: $('#no_hp_1_edit').val(),
            phone_2: $('#no_hp_2_edit').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit Vendor dengan Kode: '+ $('#edit_id').val() +' ?', 
            'Diedit!', 'Vendor dengan kode: '+ $('#edit_id').val() +' berhasil diedit.', 'modal_edit'
        );
    });

</script>
