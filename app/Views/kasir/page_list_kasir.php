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

                        <!-- btn add transaksi -->
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add"> Tambah Transaksi </button>
                            </div>
                        </div>
                        
                        <!-- main table -->
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
                                                        <th class="text-center">No Invoice</th>
                                                        <th class="text-center">Kode Registrasi</th>
                                                        <th class="text-center">Nama Customer</th>
                                                        <th class="text-center">Waktu</th>
                                                        <th class="text-center">Subtotal</th>
                                                        <th class="text-center">Status Pembayaran</th>
                                                        <th class="text-center">Detail</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table rows will be added dynamically -->
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
                "url": "<?= site_url('transaksi/ajax_get_list_transaksi') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3, 4, 5, 6, 7 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 2, 6, 7 ],
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
                $('#selected_item_harga').val(response.item_price);
                $('#selected_item_id').val(idItem);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching additional data:', error);
            }
        });
    });

</script>
