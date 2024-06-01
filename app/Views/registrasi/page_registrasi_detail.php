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

                        <!-- header detail  -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-white">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-center mb-3">
                                                <h2>
                                                    <?= generate_general_code('CRC',$data_registrasi[0]->id, 6) ?>
                                                </h2>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label>Pasien :</label>
                                                <input type="text" class="form-control text-center" readonly
                                                    value="<?= $data_registrasi[0]->nama_pasien .'('.$data_registrasi[0]->kode_pasien.')' ?>"
                                                />
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label>Dokter/Beautycian :</label>
                                                <input type="text" class="form-control text-center" readonly
                                                    value="<?= $data_registrasi[0]->nama_karyawan ?>"
                                                />
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label>Rencana Kunjungan :</label>
                                                <input type="text" class="form-control text-center" readonly
                                                    value="<?= $data_registrasi[0]->plan_date ?>"
                                                />
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label>Tanggal Berkunjung :</label>
                                                <input type="text" class="form-control text-center" readonly
                                                    value="<?= $data_registrasi[0]->actual_date ?>"
                                                />
                                            </div>
                                            <div class="col-12 text-center">
                                                <hr>
                                            </div>
                                            <div class="col-12">
                                                <div class="dropdown">
                                                    <?php
                                                        switch ($data_registrasi[0]->status) {
                                                            case 'scheduled':
                                                                $btn_color = 'btn-warning';
                                                                $disable_set = '';
                                                                break;
                                                            case 'waiting':
                                                                $btn_color = 'btn-danger';
                                                                $disable_set = '';
                                                                break;
                                                            case 'on treatment':
                                                                $btn_color = 'btn-info';
                                                                $disable_set = '';
                                                                break;
                                                            case 'done':
                                                                $btn_color = 'btn-success';
                                                                $disable_set = 'disabled';
                                                                break;
                                                            default:
                                                                $btn_color = 'btn-primary';
                                                                $disable_set = '';
                                                                break;
                                                        }
                                                    ?>
                                                    <button class="btn <?= $btn_color ?> dropdown-toggle" type="button" 
                                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" 
                                                        aria-expanded="false" <?= $disable_set ?>
                                                    >
                                                        <?= $data_registrasi[0]->status ?>
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                        style="right:0"
                                                    >
                                                        <a id="btn_status_scheduled" class="dropdown-item" href="#">Scheduled</a>
                                                        <a id="btn_status_waiting" class="dropdown-item" href="#">Waiting</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                            data-bs-target="#modal_on_treatment"
                                                        >
                                                            On Treatment
                                                        </a>
                                                        <a id="btn_status_done" class="dropdown-item" href="#">Done</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-sm-12 text-left">
                                                <?php if($data_registrasi[0]->status != 'done') : ?> 
                                                    <button class="btn btn-primary" data-bs-toggle="modal" 
                                                        data-bs-target="#modal_add_item"
                                                    > 
                                                        + Tambah Item
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="main_table" class="table table-bordered nowrap" 
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Kode Item</th>
                                                        <th class="text-center">Nama Item</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-center">Satuan</th>
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

        <!-- modal add item -->
        <div id="modal_add_item" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="btn_close_modal_add"
                        >
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add_item" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header">Detail Transaksi</div>
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
                                                        Tambah
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
                                                        <th>Aksi</th>
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
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_add_item">
                                        Konfirmasi Tambah Item
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal add -->
        <div id="modal_on_treatment" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Konfirmasi Status "On Treatment"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_on_treatment" method="POST">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label for="change_staff">Ganti Staff ?</label>
                                    <select class="form-control select2" id="change_staff" name="change_staff" style="width: 100%;">
                                        <option value="">Pilih Dokter/Beautician</option>
                                        <?php
                                            foreach($data_staff as $row){
                                                echo '
                                                    <option value="'.$row->id.'"> '.
                                                        $row->no_induk.' - '.$row->nama.' - '.$row->entitas_name.
                                                    '</option>
                                                ';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_status_on_treatment" >
                                        Konfirmasi
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
    const id_detail = "<?= $id_detail ?>"
    const baseUrl = "<?= base_url() ?>";
    var mainTable;

    console.log('<?= json_encode($id_detail) ?>', 'idDetail');

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
                "url": "<?= site_url('registrasi/ajax_get_registrasi_detail/'.$id_detail) ?>",
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

    // on modal_add_item show
    $('#modal_add_item').on('shown.bs.modal', function () {
        // reset dropdown produk
        resetSelect2('selected_item', 'Pilih Produk');

        // load item dropdown
        setSearchableDropdown('selected_item', 3, "<?= base_url('item/ajax_get_item_list') ?>");
    });

    // on modal_add_item hide
    $('#modal_add_item').on('hidden.bs.modal', function () {
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

    // konfirmasi add item
    $(document).on('click', '#btn_konfirmasi_add_item', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('registrasi/add_registrasi_detail') ?>";
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
            id_registration: "<?= $data_registrasi[0]->id ?>",
            id_entitas: "<?= $data_registrasi[0]->id_entitas ?>",
            item_detail: rowsData
        };
        
        loadQuestionalSwal(
            path, data, 'Tambah Item Transaksi ?', 
            'Ditambahkan!', 'Item baru berhasil ditambahkan pada transaksi ini', 'modal_add_item'
        );
    });

    // btn btn_status_done
    $(document).on('click', '#btn_status_done', function () {
        const path = '<?= base_url('registrasi/done_status') ?>';
        const data = {
            id_registrasi: <?= $id_detail ?>,
            notes: 'Belum Ada'
        };
        
        loadQuestionalSwal(
            path, data, 'Selesaikan transaksi ini ?', 
            'Diselesaikan!', 'Transaksi ini berhasil diselesaikan.', '', false, true
        );
    });

    // btn btn_status_waiting
    $(document).on('click', '#btn_status_waiting', function () {
        const path = '<?= base_url('registrasi/waiting_status') ?>';
        const data = {
            id_registrasi: <?= $id_detail ?>
        };
        
        loadQuestionalSwal(
            path, data, 'Ubah ke waiting?', 
            'Diubah!', 'Status saat ini WAITING.', '', false, true
        );
    });

    // btn btn_status_on_treatment
    $(document).on('click', '#btn_status_on_treatment', function () {
        const path = '<?= base_url('registrasi/on_treatment_status') ?>';

        const data = {
            id_registrasi: <?= $id_detail ?>,
            id_staff: $('#change_staff').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Ubah ke On Treatment?', 
            'Diubah!', 'Status saat ini ON TREATMENT.', '', false, true
        );
    });


</script>
