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

                        <!-- Card Report -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-1 overflow-hidden">
                                                <p class="text-truncate font-size-14 mb-2">Total Pengeluaran</p>
                                                <h4 class="mb-0">1452</h4>
                                            </div>
                                            <div class="text-primary ms-auto">
                                                <i class="ri-stack-line font-size-24"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-1 overflow-hidden">
                                                <p class="text-truncate font-size-14 mb-2">Jumlah Pengeluaran</p>
                                                <h4 class="mb-0">$ 38452</h4>
                                            </div>
                                            <div class="text-primary ms-auto">
                                                <i class="ri-store-2-line font-size-24"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-1 overflow-hidden">
                                                <p class="text-truncate font-size-14 mb-2">Rata Rata Pengeluaran</p>
                                                <h4 class="mb-0">$ 15.4</h4>
                                            </div>
                                            <div class="text-primary ms-auto">
                                                <i class="ri-briefcase-4-line font-size-24"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                    <a class="btn btn-danger ml-3" onClick="reloadPage()"> Reset </a>
                                                    <button type="submit" class="btn btn-dark ml-3"> Filter </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
