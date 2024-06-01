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

                        

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add"> Tambah Data </button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <div class="table-responsive"> -->
                                            <table id="main_table" class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Nama Entitas</th>
                                                        <th class="text-center">Tipe</th>
                                                        <th class="text-center">Alamat</th>
                                                        <th class="text-center">Kota</th>
                                                        <th class="text-center">Provinsi</th>
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
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Entitas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="name_entitas" class="form-label">Nama Entitas</label>
                                    <input class="form-control" type="text" id="name_entitas" name="name_entitas" placeholder="Nama Entitas" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tipe_entitas" class="form-label">Tipe Entitas</label>
                                    <input class="form-control" type="text" id="tipe_entitas" name="tipe_entitas" placeholder="Tipe Entitas" />
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
                                <div class="col-lg-6 mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select class="form-control select2" data-trigger name="provinsi" id="provinsi">
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
                                <div class="col-lg-12 mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input class="form-control" type="text" id="alamat" name="alamat" placeholder="Alamat" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_simpan" >
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
        <div id="modal_edit" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Entitas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="name_entitas_edit" class="form-label">Nama Entitas</label>
                                    <input class="form-control" type="text" id="name_entitas_edit" name="name_entitas_edit" placeholder="Nama Entitas" />
                                    <input type="hidden" id="edit_id" name="edit_id" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tipe_entitas_edit" class="form-label">Tipe Entitas</label>
                                    <input class="form-control" type="text" id="tipe_entitas_edit" name="tipe_entitas_edit" placeholder="Tipe Entitas" />
                                </div>
                                <div class="col-lg-12 mb-3">
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
                            </div>
                            <div class="row">
                                <div class="col-lg-6" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit" 
                                        data-path="<?= base_url('entitas_usaha/add/entitas_usaha') ?>"
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
                "url": "<?= site_url('entitas_usaha/ajax_get_list_entitas') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3, 5, 6 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 6 ],
                    "orderable": false,
                },
            ],
        });
    }

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('entitas_usaha/add_entitas_usaha') ?>";
        const data = {
            nama: $('#name_entitas').val(),
            id_entitas_tipe: $('#tipe_entitas').val(),
            id_kota: $('#kota').val(),
            alamat: $('#alamat').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Simpan Entitas Usaha dengan nama: '+$('#name_entitas').val()+' ?', 
            'Disimpan!', 'Entitas Usaha dengan nama: '+$('#name_entitas').val()+' berhasil disimpan.', 'modal_add'
        );
    });

    // delete
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('entitas_usaha/delete_entitas_usaha') ?>";
        const data = {
            id : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus Entitas Usaha dengan nama: '+thisData['nama']+' ?', 
            'Dihapus!', 'Entitas Usaha dengan nama: '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit', function() {
        var editId = $(this).data('id');
        const path = "<?= site_url('entitas_usaha/ajax_get_entitas_data') ?>";
        
        $.ajax({
            url: path,
            method: 'POST',
            data: { id_entitas: editId },
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#edit_id').val(editId);
                $('#name_entitas_edit').val(response.nama);
                $('#tipe_entitas_edit').val(response.nama_entitas_tipe);
                $('#alamat_edit').val(response.alamat);
                $('#kota_edit').val(response.id_kota);
                $('#provinsi_edit').val(response.id_provinsi);
                
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
        const path = "<?= site_url('entitas_usaha/edit_entitas_usaha') ?>";
        const data = {
            id_edit: $('#edit_id').val(),
            nama: $('#name_entitas_edit').val(),
            id_entitas_tipe: $('#tipe_entitas_edit').val(),
            id_kota: $('#kota_edit').val(),
            alamat: $('#alamat_edit').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit Entitas Usaha dengan Nama: '+ $('#name_entitas_edit').val() +' ?', 
            'Diedit!', 'Entitas Usaha dengan Nama: '+ $('#name_entitas_edit').val() +' berhasil diedit.', 'modal_edit'
        );
    });

</script>
