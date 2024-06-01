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
                                <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#modal_add"> 
                                    + Registrasi Pasien
                                </button>
                                <a href="pasien-get-list" class="btn btn-primary mr-2"> 
                                    Data Pasien
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="main_table" class="table table-bordered nowrap" 
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Cabang</th>
                                                        <th class="text-center">Kode Pasien</th>
                                                        <th class="text-center">Nama Pasien</th>
                                                        <th class="text-center">Nama Staff</th>
                                                        <th class="text-center">Rencana Kunjungan</th>
                                                        <th class="text-center">Tanggal Kunjungan</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Detail</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
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
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Registrasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="entitas" class="form-label">Cabang</label>
                                    <select class="form-control select2" data-trigger name="entitas" id="entitas">
                                        <option value="">Pilih Cabang</option>
                                        <?php
                                            foreach($list_entitas as $row){
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
                                    <label for="pasien" class="form-label">Pasien</label>
                                    <select class="select2" data-trigger name="pasien" id="pasien">
                                        <option value="">Pilih Pasien</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="plan_date" class="form-label">Rencana Kunjungan</label>
                                    <input class="form-control" type="datetime-local" id="plan_date" name="plan_date" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="staff" class="form-label">Staff</label>
                                    <input class="form-control" type="text" id="staff" name="staff"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_simpan">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal Edit -->
        <div id="modal_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="kode_item_edit" class="form-label">Kode Item</label>
                                    <input class="form-control" type="text" id="kode_item_edit" name="kode_item_edit" placeholder="Kode Item" />
                                    <input type="hidden" id="edit_id" name="edit_id" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="barcode_edit" class="form-label">Barcode</label>
                                    <input class="form-control" type="text" id="barcode_edit" name="barcode_edit" placeholder="Barcode" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama_edit" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama_edit" name="nama_edit" placeholder="Nama" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="kategori_edit" class="form-label">Kategori</label>
                                    <input class="form-control" type="text" id="kategori_edit" name="kategori_edit" placeholder="Kategori" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="jenis_edit" class="form-label">Jenis</label>
                                    <input class="form-control" type="text" id="jenis_edit" name="jenis_edit" placeholder="Jenis" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="brand_edit" class="form-label">Brand</label>
                                    <input class="form-control" type="text" id="brand_edit" name="brand_edit" placeholder="brand" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="supplier_edit" class="form-label">Supplier</label>
                                    <input class="form-control" type="text" id="supplier_edit" name="supplier_edit" placeholder="Supplier" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="stock_minimum_edit" class="form-label">Stock Minimum</label>
                                    <input class="form-control" type="text" id="stock_minimum_edit" name="stock_minimum_edit" placeholder="Stock Minimum" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="satuan_edit" class="form-label">Satuan</label>
                                    <input class="form-control" type="text" id="satuan_edit" name="satuan_edit" placeholder="Satuan" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit" 
                                        data-path="<?= base_url('item/add/item') ?>"
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
                "url": "<?= site_url('registrasi/ajax_get/list_registrasi') ?>",
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
        const path = '<?= base_url('registrasi/add/registrasi') ?>';
        const data = {
            entitas: $('#entitas').val(),
            pasien: $('#pasien').val(),
            plan_date: $('#plan_date').val(),
            staff: $('#staff').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Tambahkan Registrasi untuk pasien: '+$('#pasien').val()+' ?', 
            'Ditambahkan!', 'Registrasi untuk pasien: '+$('#pasien').val()+' berhasil ditambahkan.', 'modal_add'
        );
    });

    // delete
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('satuan/delete/data_satuan') ?>";
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
        var editId = $(this).data('id');
        const path = "<?= site_url('satuan/ajax_get/edit_data') ?>";
        const kode_urut = $(this).data('kode_urut');
        
        $.ajax({
            url: path,
            method: 'POST',
            data: { edit_id: editId },
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#edit_id').val(editId);
                $('#kode_urut_edit').val(kode_urut);
                $('#kode_edit').val(response.kode);
                $('#nama_edit').val(response.nama);
                $('#deskripsi_edit').val(response.deskripsi);
                
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
        const path = thisData['path'];
        const data = {
            edit_id: $('#edit_id').val(),
            kode_edit: $('#kode_edit').val(),
            nama_edit: $('#nama_edit').val(),
            deskripsi_edit: $('#deskripsi_edit').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit Satuan dengan Kode Urut: '+ $('#kode_urut_edit').val() +' ?', 
            'Diedit!', 'Satuan dengan kode Urut: '+ $('#kode_urut_edit').val() +' berhasil diedit.', 'modal_edit'
        );
    });

    // pasien searc dropdown
    $(document).ready(function() {
        const path = '<?= base_url('pasein/ajax_get/search_pasien') ?>';
        $('#pasien').select2({
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    // Map your data to Select2 format
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nama + ' - ' + item.kode_pasien
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3,
            placeholder: 'Cari pasien...',
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: function(data) {
                return data.text;
            },
            templateSelection: function(data) {
                return data.text;
            },
            tags: true
        });
    });


</script>
