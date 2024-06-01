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
                                                    <label for="filter_divisi" class="form-label">Divisi</label>
                                                    <select class="form-control select2" data-trigger name="filter_divisi" id="filter_divisi">
                                                    <option value="">Pilih Divisi</option>
                                                        <?php
                                                            foreach($data_divisi as $row){
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
                                                    <label for="filter_kota" class="form-label">Entitas</label>
                                                    <select class="form-control select2" data-trigger name="filter_entitas" id="filter_entitas">
                                                        <option value="">Pilih Entitas</option>
                                                        <?php
                                                            foreach($data_entitas as $row){
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
                                                    <a id="btn-filter" class="btn btn-dark ml-3"> Filter </a>
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
                                        <!-- <div class="table-responsive"> -->
                                            <table id="main_table" class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">NIP</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">No HP</th>
                                                        <th class="text-center">Jabatan</th>
                                                        <th class="text-center">Divisi</th>
                                                        <th class="text-center">Entitas</th>
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
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input class="form-control" type="text" id="nip" name="nip" placeholder="NIP" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input class="form-control num-only" type="text" id="no_hp" name="no_hp" placeholder="No Hp" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select class="form-control select2" id="jabatan" name="jabatan">
                                        <option value="">Pilih Jabatan</option>
                                        <?php foreach ($data_jabatan as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <select class="form-control select2" id="divisi" name="divisi">
                                        <option value="">Pilih Divisi</option>
                                        <?php foreach ($data_divisi as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="entitas" class="form-label">Entitas</label>
                                    <select class="form-control select2" id="entitas" name="entitas">
                                        <option value="">Pilih Entitas</option>
                                        <?php foreach ($data_entitas as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_simpan" data-object="<?= base_url('karyawan/add/karyawan') ?>">
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
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="nip_edit" class="form-label">NIP</label>
                                    <input class="form-control" type="text" id="nip_edit" name="nip_edit" placeholder="NIP" />
                                    <input type="hidden" id="edit_id" name="edit_id" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama_edit" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama_edit" name="nama_edit" placeholder="Nama" />
                                    <input type="hidden" id="edit_id" name="edit_id" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="no_hp_edit" class="form-label">No HP</label>
                                    <input class="form-control num-only" type="text" id="no_hp_edit" name="no_hp_edit" placeholder="No Hp" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="jabatan_edit" class="form-label">Jabatan</label>
                                    <select class="form-control select2" id="jabatan_edit" name="jabatan_edit">
                                        <option value="">Pilih Jabatan</option>
                                        <?php foreach ($data_jabatan as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="divisi_edit" class="form-label">Divisi</label>
                                    <select class="form-control select2" id="divisi_edit" name="divisi_edit">
                                        <option value="">Pilih Divisi</option>
                                        <?php foreach ($data_divisi as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="entitas_edit" class="form-label">Entitas</label>
                                    <select class="form-control select2" id="entitas_edit" name="entitas_edit">
                                        <option value="">Pilih Entitas</option>
                                        <?php foreach ($data_entitas as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit" data-object="<?= base_url('karyawan/add/karyawan') ?>">
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
                "url": "<?= site_url('karyawan/ajax_get/list_karyawan') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                    data.filter_divisi = $('#filter_divisi').val();
                    data.filter_entitas = $('#filter_entitas').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 3, 4, 5, 6, 7 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 7 ],
                    "orderable": false,
                },
            ],
        });
    }

    // btn filter
    $('#btn-filter').click(function(){ 
        mainDatatable(); 
    });

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('karyawan/add_karyawan') ?>";
        const data = {
            no_induk: $('#nip').val(),
            nama: $('#nama').val(),
            hp: $('#no_hp').val(),
            id_jabatan: $('#jabatan').val(),
            id_divisi: $('#divisi').val(),
            id_entitas: $('#entitas').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Simpan Karyawan dengan nama: '+$('#nama').val()+' ?', 
            'Disimpan!', 'Karyawan dengan nama: '+$('#nama').val()+' berhasil disimpan.', 'modal_add'
        );
    });

    // delete customer 
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('karyawan/delete_karyawan') ?>";
        const data = {
            id : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus Karyawan Dengan Nama: '+thisData['nama']+' ?', 
            'Dihapus!', 'Karyawan dengan Nama: '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit', function() {
        var idKaryawan = $(this).data('id');
        const path = "<?= site_url('karyawan/ajax_get_karyawan_data') ?>";
        
        $.ajax({
            url: path,
            method: 'POST',
            data: { id_karyawan: idKaryawan },
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#edit_id').val(idKaryawan);
                $('#nip_edit').val(response.no_induk);
                $('#barcode_edit').val(response.nama);
                $('#nama_edit').val(response.nama);
                $('#no_hp_edit').val(response.hp);
                $('#jabatan_edit').val(response.id_jabatan).trigger('change');
                $('#divisi_edit').val(response.id_divisi).trigger('change');
                $('#entitas_edit').val(response.id_entitas).trigger('change');
                
                // Show the modal
                $('#modal_edit').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    });

    

</script>
