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

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add"> 
                                    Tambah Data Cash Drawer 
                                </button>
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

        <!-- modal add -->
        <div id="modal_add" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn_close_modal_add"
                        >
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header">Detail Cash Drawer</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <label for="for_date">Untuk Tanggal</label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                            data-date-autoclose="true" id="for_date"
                                                        >

                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea id="deskripsi" class="form-control"></textarea>
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <label for="debit">Debit</label>
                                                    <input id="debit" type="number" class="form-control" />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <label for="credit">Credit</label>
                                                    <input id="credit" type="number" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <label for="btn_add_detail" class="text-white">btn</label>
                                                    <span class="btn btn-primary form-control" id="btn_add_detail">
                                                        Tambah
                                                    </span>
                                                </div>
                                            </div>

                                            <table class="table mt-3">
                                                <thead>
                                                    <tr>
                                                        <th>Deskripsi</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cashDrawerDetail">
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_add_detail">
                                        Konfirmasi Tambah Detail
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal edit -->
        <div id="modal_edit" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                    <label for="kode_pasien_edit" class="form-label">Kode Pasien</label>
                                    <input class="form-control text-center" type="text" id="kode_pasien_edit" name="kode_pasien_edit" disabled/>
                                    <input id="edit_id" type="hidden"/>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama_pasien_edit" class="form-label">Nama Pasien</label>
                                    <input class="form-control" type="text" id="nama_pasien_edit" name="nama_pasien_edit" placeholder="Nama Pasien" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tanggal_lahir_datepicker_edit" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group" id="tanggal_lahir_datepicker_edit">
                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                            data-date-format="yyyy-mm-dd" data-date-container='#tanggal_lahir_datepicker_edit' data-provide="datepicker"
                                            data-date-autoclose="true" id="tanggal_lahir_edit" name="tanggal_lahir_edit"
                                        >
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="nohp_edit" class="form-label">No Hp</label>
                                    <input class="form-control num-only" type="text" id="nohp_edit" name="nohp_edit" placeholder="08xx" />
                                    <small class="text-muted">Please enter only numeric characters (0-9).</small>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="kota_edit" class="form-label">Kota</label>
                                    <select class="form-control select2" data-trigger name="kota_edit" id="kota_edit">
                                        <option value="">Pilih Kota</option>
                                        
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="alamat_edit" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat_edit" name="alamat_edit"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit" data-object="<?= base_url('pasien/add/pasien') ?>">
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
