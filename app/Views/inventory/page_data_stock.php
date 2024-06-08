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
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <div class="table-responsive"> -->
                                            <table id="main_table" class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <?php 
                                                        $counted_entitas = 0;
                                                        foreach($data_entitas_usaha as $list):
                                                            $counted_entitas += 1;
                                                        endforeach; 
                                                    ?>
                                                    
                                                    <tr>
                                                        <th class="text-center" rowspan="2">No.</th>
                                                        <th class="text-center" rowspan="2">Kode Item</th>
                                                        <th class="text-center" rowspan="2">Nama Item</th>
                                                        <th class="text-center" rowspan="2">Satuan</th>
                                                        <th class="text-center" colspan="<?= $counted_entitas ?>">Entitas</th>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach($data_entitas_usaha as $list): ?>
                                                            <th class="text-center"><?= $list->nama ?></th>
                                                        <?php endforeach; ?>
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

        let columnCount = [0, 1, 3, ];
        let dataEntitasUsaha = <?= json_encode($data_entitas_usaha) ?>;

        dataEntitasUsaha.forEach((item, index) => {
            columnCount.push(index+4);
        });

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
                "url": "<?php echo site_url('Item_stock_management/ajax_get_list_stock')?>",
                "type": "POST",
                "data": function ( data ) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": columnCount,
                    "className": "text-center"
                },
                { 
                    "targets": [ 0 ],
                    "orderable": false,
                },
            ],
		});
    }

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('pasien/add_pasien') ?>";
        const data = {
            kode_pasien: $('#kode_pasien').val(),
            nama: $('#nama_pasien').val(),
            tanggal_lahir: $('#tanggal_lahir').val(),
            alamat: $('#alamat').val(),
            phone: $('#nohp').val(),
            id_kota: $('#kota').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Simpan Pasien dengan nama: '+$('#nama_pasien').val()+' ?', 
            'Disimpan!', 'Pasien dengan nama: '+$('#nama_pasien').val()+' berhasil disimpan.', 'modal_add'
        );
    });

    // delete customer 
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('pasien/delete_pasien') ?>";
        const data = {
            id : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus Pasien Dengan Nama: '+thisData['nama']+' ?', 
            'Dihapus!', 'Pasien dengan Nama: '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit', function() {
        var idPasien = $(this).data('id');
        const path = "<?= site_url('pasien/ajax_get_pasien_data') ?>";
        
        $.ajax({
            url: path,
            method: 'POST',
            data: { id_pasien: idPasien },
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#edit_id').val(idPasien);
                $('#tanggal_lahir_edit').val(response.tanggal_lahir);
                $('#nama_pasien_edit').val(response.nama);
                $('#kota_edit').val(response.id_kota).trigger('change');
                $('#alamat_edit').val(response.alamat);
                $('#nohp_edit').val(response.phone);
                $('#kode_pasien_edit').val(response.kode_pasien);
                
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
        const path = "<?= site_url('pasien/edit_pasien') ?>";
        const data = {
            edit_id: $('#edit_id').val(),
            nama: $('#nama_pasien_edit').val(),
            tanggal_lahir: $('#tanggal_lahir_edit').val(),
            alamat: $('#alamat_edit').val(),
            phone: $('#nohp_edit').val(),
            id_kota: $('#kota_edit').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit Pasien dengan Kode: '+ $('#kode_pasien_edit').val() +' ?', 
            'Diedit!', 'Pasien dengan kode: '+ $('#kode_pasien_edit').val() +' berhasil diedit.', 'modal_edit'
        );
    });


</script>
