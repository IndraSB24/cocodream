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
                        <!-- <div class="row">
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
                        </div> -->
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
                                                        <th class="text-center">Entitas</th>
                                                        <th class="text-center">Total Kegiatan</th>
                                                        <th class="text-center">Total Debit</th>
                                                        <th class="text-center">Total Kredit</th>
                                                        <th class="text-center">Aksi</th>
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
                "url": "<?php echo site_url('cash_drawer/ajax_get_list_cashdrawer')?>",
                "type": "POST",
                "data": function ( data ) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                "targets": [ 0, 1, 2, 3, 4, 5, 6 ],
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

    // on modal_add hide
    $('#modal_add').on('hidden.bs.modal', function () {
        // Clear form fields
        clearFieldValue([
            'deskripsi', 'debit', 'credit'
        ]);

        // clear cashDrawerDetail content
        resetElementValue('cashDrawerDetail');
    });

    // add item
    $(document).on('click', '#btn_add_detail', function (e) {
        e.preventDefault();

        // Append transaction details to table with delete button
        $('#cashDrawerDetail').append(
            '<tr>' +
            '<td>' + $('#deskripsi').val() + '</td>' +
            '<td>' + $('#debit').val() + '</td>' +
            '<td>' + $('#credit').val() + '</td>' +
            '<td>' +
                '<button class="btn btn-warning" id="deleteRow">Delete</button>'+
            '</td>' +
            '</tr>'
        );

        // Clear form fields
        clearFieldValue([
            'deskripsi', 'debit', 'credit'
        ]);
    });

    // Attach click event handler to delete buttons
    $('#cashDrawerDetail').on('click', '#deleteRow', function () {
        $(this).closest('tr').remove();
    });

    // konfirmasi add item
    $(document).on('click', '#btn_konfirmasi_add_detail', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('cash_drawer/add_cashdrawer_detail') ?>";
        var rowsData = [];

        // Iterate over each row in the table
        $('#cashDrawerDetail tr').each(function() {
            var rowData = {};
            
            // Find each cell (td) in the current row
            $(this).find('td').each(function(index) {
                // Extract the data from the cell and store it in the rowData object
                switch(index) {
                    case 0:
                        rowData.deskripsi = $(this).text();
                        break;
                    case 1:
                        rowData.debit = parseFloat($(this).text());
                        break;
                    case 2: 
                        rowData.credit = parseFloat($(this).text());
                        break;
                }
            });
            
            rowsData.push(rowData);
        });

        const data = {
            cashdrawer_detail: rowsData,
            for_date: $('#for_date').val()
        };

        loadQuestionalSwal(
            path, data, 'Tambah Detail Cash Drawer ?', 
            'Ditambahkan!', 'Detail baru berhasil ditambahkan pada Cash Drawer untuk Tanggal '+$('#for_date').val(), 'modal_add'
        );
    });

    // Attach click event handler to delete buttons
    $('#cashDrawerDetail').on('click', '#deleteRow', function () {
        $(this).closest('tr').remove();
    });


</script>
