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
                                <a id="btn_show_rekap_absensi" class="btn btn-primary" 
                                    href="<?= base_url('show-rekap-absensi/') ?>"
                                > 
                                    Rekap Absensi Anda 
                                </a>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center text-center">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="assets/images/companies/img-1.png" alt="img-1" class="avatar-sm mt-2 mb-4">
                                            <div class="flex-1">
                                                <h5 class="text-truncate">
                                                    <?php echo isset($today_data->status) ? $today_data->status : 'Belum Absen'; ?>
                                                </h5>
                                                <p class="text-muted">
                                                    <?php 
                                                        echo isset($today_data->waktu_keluar) ? 
                                                            $today_data->waktu_keluar : 
                                                            (isset($today_data->waktu_masuk) ? 
                                                                $today_data->waktu_masuk : 
                                                                ''
                                                            ); 
                                                        ; 
                                                    ?>
                                                </p>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="row text-center">
                                            <div class="col-6">
                                                <button id="btn_absen_in" class="btn btn-info"
                                                    <?= isset($today_data->waktu_masuk) ? 'disabled' : '' ?>
                                                > 
                                                    Masuk
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button id="btn_absen_out" class="btn btn-warning" 
                                                    <?= isset($today_data->waktu_keluar) ? 'disabled' : '' ?>
                                                > 
                                                    Keluar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
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
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="kode" class="form-label">Kode Satuan</label>
                                    <input class="form-control" type="text" id="kode" name="kode" placeholder="Kode Satuan" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama Satuan" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input class="form-control" type="text" id="deskripsi" name="deskripsi" placeholder="Deskripsi" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_simpan" 
                                        data-path="<?= base_url('satuan/add/satuan') ?>"
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
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="kode_urut_edit" class="form-label">Kode Urut</label>
                                    <input class="form-control text-center" type="text" id="kode_urut_edit" name="kode_urut_edit" disabled />
                                    <input type="hidden" id="edit_id" name="edit_id" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="kode_edit" class="form-label">Kode Satuan</label>
                                    <input class="form-control" type="text" id="kode_edit" name="kode_edit" placeholder="Kode Satuan" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama_edit" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama_edit" name="nama_edit" placeholder="Nama Satuan" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="deskripsi_edit" class="form-label">Deskripsi</label>
                                    <input class="form-control" type="text" id="deskripsi_edit" name="deskripsi_edit" placeholder="Deskripsi" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit" 
                                        data-path="<?= base_url('satuan/edit/satuan') ?>"
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

        <!-- JS -->
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
        console.log("<?= json_encode($today_data) ?>");
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
                "url": "<?= site_url('kategori/ajax_get_by_tipe/item_jenis') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 3 ],
                    "orderable": false,
                },
            ],
        });
    }

    // simpan
    $(document).on('click', '#btn_absen_in', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const path = "<?= base_url('absensi/do_absen/masuk') ?>";
                const data = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };

                loadQuestionalSwal(
                    path, data, 'Absen Masuk ?',
                    'Berhasil!', 'Anda Berhasil Absen Masuk', '', false, true
                );
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });

    $(document).on('click', '#btn_absen_out', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const path = "<?= base_url('absensi/do_absen/keluar') ?>";
                const data = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };

                loadQuestionalSwal(
                    path, data, 'Absen Pulang ?', 
                    'Berhasil!', 'Anda Berhasil Absen Pulang', '', false, true
                );
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
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

</script>
