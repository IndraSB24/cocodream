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
                                                    <label for="filter_pasien" class="form-label">Pasien</label>
                                                    <select class="form-control select2" data-trigger name="filter_pasien" id="filter_pasien">
                                                        <option value="">Pilih Pasien</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label for="filter_dari_tanggal" class="form-label">Dari Tanggal</label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                            data-date-autoclose="true" id="filter_dari_tanggal"
                                                        >

                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label for="filter_sampai_tanggal" class="form-label">Sampai Tanggal</label>
                                                    <div class="input-group" id="datepicker2">
                                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd"
                                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                            data-date-autoclose="true" id="filter_sampai_tanggal"
                                                        >

                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-12" style="text-align: right">
                                                    <a id="btn_filter_reset" class="btn btn-danger ml-3"> Reset </a>
                                                    <a id="btn_filter" class="btn btn-dark ml-3"> Filter </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- btn add transaksi -->
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add"> 
                                    Tambah EMR
                                </button>
                            </div>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <div class="timeline">
                                    <div id="medical_record_container">
                                        <div class="text-center mt-5">
                                            <h3>Choose Patient First</h3>
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
        <div id="modal_add" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn_close_modal_add"
                        >
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="pasien" class="form-label">Pasien</label>
                                    <select class="form-control select2" id="pasien" name="pasien" style="width: 100%;">
                                        <option value="">Pilih Pasien</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input class="form-control" type="datetime-local" id="tanggal" name="tanggal" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header">Detail Transaction</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 mb-3">
                                                    <label for="selected_item">Produk</label>
                                                    <select class="form-control select2" id="selected_item" name="selected_item" style="width: 100%;">
                                                        <option value="">Pilih Produk</option>
                                                    </select>
                                                    <input type="hidden" id="selected_item_nama"/>
                                                    <input type="hidden" id="selected_item_harga"/>
                                                    <input type="hidden" id="selected_item_id"/>
                                                </div>
                                                <div class="col-sm-2 mb-3">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" class="form-control" id="jumlah"/>
                                                </div>
                                                <div class="col-sm-2 mb-3">
                                                    <label for="satuan">Satuan</label>
                                                    <input type="text" id="selected_item_satuan" class="form-control"/>
                                                </div>
                                                <div class="col-sm-2 mb-3">
                                                    <label for="btn_add_item" class="text-white">btn</label>
                                                    <span class="btn btn-primary form-control" id="btn_add_item">
                                                        Add Transaction
                                                    </span>
                                                </div>
                                            </div>

                                            <table class="table mt-3">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                        <th>Harga</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="transactionDetails">
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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

        <!-- modal edit -->
        <div id="modal_edit" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

        // reset dropdown filter_pasien
        resetSelect2('filter_pasien', 'Pilih Pasien');

        // load filter_pasien dropdown
        setSearchableDropdown('filter_pasien', 3, "<?= base_url('pasien/ajax_get_pasien') ?>");
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
                "url": "<?= site_url('absensi/ajax_get_list_absensi') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3, 4 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 4 ],
                    "orderable": false,
                },
            ],
        });
    }

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('transaksi/add_transaksi') ?>";
        var rowsData = [];

        // Iterate over each row in the table
        $('#transactionDetails tr').each(function() {
            var rowData = {};
            
            // Find each cell (td) in the current row
            $(this).find('td').each(function(index) {
                // Extract the data from the cell and store it in the rowData object
                switch(index) {
                    case 0:
                        rowData.nama = $(this).text();
                        break;
                    case 1:
                        rowData.harga = parseFloat($(this).text());
                        break;
                    case 2: 
                        rowData.jumlah = parseFloat($(this).text());
                        break;
                    case 4: 
                        rowData.total = parseFloat($(this).text());
                        break;
                    case 5:
                        rowData.id_item = $(this).find('input[name="id_item"]').val();
                        break;
                }
            });
            
            rowsData.push(rowData);
        });

        const data = {
            id_pasien: $('#pasien').val(),
            transaction_date: $('#tanggal').val(),
            transaction_detail: rowsData
        };
        console.log(data);
        
        loadQuestionalSwal(
            path, data, 'Tambah transaksi ?', 
            'Disimpan!', 'Transaksi baru berhasil ditambahkan', 'modal_add'
        );
    });

    // delete
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('transaksi/delete_transaksi') ?>";
        const data = {
            id : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus transaksi dengan nomor invoice: '+thisData['invoice']+' ?', 
            'Dihapus!', 'Transaksi dengan invoice: '+thisData['invoice']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit_1', function() {
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
    
    // on modal_add show
    $('#modal_add').on('shown.bs.modal', function () {
        // reset dropdown produk
        resetSelect2('selected_item', 'Pilih Produk');

        // reset dropdown pasien
        resetSelect2('pasien', 'Pilih Pasien');

        // load pasien dropdown
        setSearchableDropdown('pasien', 3, "<?= base_url('pasien/ajax_get_pasien') ?>");

        // load item dropdown
        setSearchableDropdown('selected_item', 3, "<?= base_url('item/ajax_get_item_list') ?>");
    });

    // on modal_add hide
    $('#modal_add').on('hidden.bs.modal', function () {
        // Clear form fields
        clearFieldValue([
            'jumlah', 'selected_item_nama', 'selected_item_satuan', 'selected_item_harga'
        ]);

        // clear transactionDetails content
        resetElementValue('transactionDetails');
    });

    // add item
    $(document).on('click', '#btn_add_item', function (e) {
        e.preventDefault();

        // Append transaction details to table with delete button
        $('#transactionDetails').append(
            '<tr>' +
            '<td>' + $('#selected_item_nama').val() + '</td>' +
            '<td>' + $('#selected_item_harga').val() + '</td>' +
            '<td>' + $('#jumlah').val() + '</td>' +
            '<td>' + $('#selected_item_satuan').val() + '</td>' +
            '<td>' + $('#jumlah').val() * $('#selected_item_harga').val() + '</td>' +
            '<td>' +
            '<input type="hidden" name="id_item" value="' + $('#selected_item_id').val() + '">' +
            '<button class="btn btn-warning" id="deleteRow">Delete</button>'+
            '</td>' +
            '</tr>'
        );

        // Clear form fields
        clearFieldValue([
            'jumlah', 'selected_item_nama', 'selected_item_satuan', 'selected_item_harga'
        ]);

        // reset dropdown produk
        resetSelect2('selected_item', 'Pilih Produk');

        // reinitialize value
        setSearchableDropdown('selected_item', 3, "<?= base_url('item/ajax_get_item_list') ?>");
    });

    // Attach click event handler to delete buttons
    $('#transactionDetails').on('click', '#deleteRow', function () {
        $(this).closest('tr').remove();
    });

    // set input value change by selected item
    $('#selected_item').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var idItem = selectedOption.val();

        $.ajax({
            url: "<?= base_url('item/ajax_get_item_data') ?>",
            type: 'POST',
            data: { id_item: idItem },
            success: function(response) {
                $('#selected_item_nama').val(response.nama);
                $('#selected_item_satuan').val(response.nama_satuan);
                $('#selected_item_harga').val(response.harga_dasar);
                $('#selected_item_id').val(idItem);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching additional data:', error);
            }
        });
    });

    // filter reset
    $(document).on('click', '#btn_filter_reset', function () {
        // reset dropdown filter_pasien
        resetSelect2('filter_pasien', 'Pilih Pasien');

        // load filter_pasien dropdown
        setSearchableDropdown('filter_pasien', 3, "<?= base_url('pasien/ajax_get_pasien') ?>");

        // Clear form fields
        clearFieldValue([
            'filter_dari_tanggal', 'filter_sampai_tanggal'
        ]);

        $('#medical_record_container').html('');
        var medicalRecordHtml = `
            <div class="text-center mt-5">
                <h3>Choose Patient First</h3>
            </div>
        `;
        $('#medical_record_container').append(medicalRecordHtml);
    });

    // filter
    $('#btn_filter').click(function() {
        var formData = {
            filter_from_date: $('#filter_dari_tanggal').val(),
            filter_to_date: $('#filter_sampai_tanggal').val(),
            filter_patient: $('#filter_pasien').val()
        };

        $.ajax({
            url: '<?= base_url('emr/show_medical_record') ?>',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#medical_record_container').html(''); // Clear the current medical record
                    var medicalRecordHtml = `
                        <div class="timeline-item timeline-left">
                            <div class="timeline-block">
                                <div class="time-show-btn mt-0">
                                    <a href="#" class="btn btn-danger btn-rounded w-lg">
                                        Medical Record
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#medical_record_container').append(medicalRecordHtml);

                    // Determine initial position
                    var cardPosition = (response.data.length % 2 === 0) ? 'left' : 'right';

                    // Append new medical record items
                    $.each(response.data, function(index, record) {
                        var positionClass = cardPosition === 'left' ? 'timeline-left' : '';
                        var itemsHtml = record.items.map(function(item) {
                            return `
                                <tr>
                                    <td class="text-center">${item.item_name}</td>
                                    <td class="text-center">${item.item_quantity}</td>
                                    <td class="text-center">${item.item_satuan}</td>
                                </tr>
                            `;
                        }).join('');

                        var medicalRecordItem = `
                            <div class="timeline-item ${positionClass}">
                                <div class="timeline-block">
                                    <div class="timeline-box card">
                                        <div class="card-body">
                                            <span class="timeline-icon"></span>
                                            <div class="timeline-date">
                                                <i class="mdi mdi-circle-medium circle-dot"></i> 
                                                ${record.record_date}
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-3 text-left">
                                                    Patient
                                                </div>
                                                <div class="col-sm-9 text-left">
                                                    : ${record.patient_name ? record.patient_name : 'No Patient'}
                                                </div>
                                            </div>
                                            <table class="table border border-info mt-2">
                                                <thead>
                                                    <tr class="bg-info text-light">
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${itemsHtml}
                                                </tbody>
                                            </table>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <div class="card border border-warning">
                                                        <div class="card-header bg-transparent border-warning">
                                                            <h5 class="my-0 text-warning">
                                                                <i class="mdi mdi-alert-circle-outline me-3"></i>
                                                                Notes
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                ${record.notes ? record.notes : 'No Notes'}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#medical_record_container').append(medicalRecordItem);

                        // Toggle card position
                        cardPosition = cardPosition === 'left' ? 'right' : 'left';
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    });


</script>
