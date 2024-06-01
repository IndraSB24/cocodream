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
                                        <div class="row text-center">
                                            <h3>
                                                <?= $invoice ?>
                                            </h3>
                                            <h5>
                                                <?= $data_transaksi[0]->nama_pasien.' ('.$data_transaksi[0]->kode_pasien.')' ?>
                                            </h5>
                                            <hr>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-12 text-left">
                                                <?php if($data_transaksi[0]->payment_status == 'Belum Bayar') : ?> 
                                                    <button class="btn btn-primary" data-bs-toggle="modal" 
                                                        data-bs-target="#modal_add_item"
                                                    > 
                                                        + Tambah Item
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12">
                                        <!-- <div class="table-responsive mt-2"> -->
                                            <table id="main_table" class="table table-bordered nowrap" 
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                                            >
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Item</th>
                                                        <th class="text-center">Harga Satuan</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-center">Satuan</th>
                                                        <th class="text-center">Total</th>
                                                        <?php if($data_transaksi[0]->payment_status == 'Belum Bayar') : ?> 
                                                            <th class="text-center">Aksi</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-10 text-end"> Sub Total : </div>
                                            <div class="col-sm-2 text-end mb-2">
                                                Rp. <span id="sub_total">0</span>
                                            </div>

                                            <div class="col-sm-10 text-end"> Diskon : </div>
                                            <div class="col-sm-2 text-end mb-2">
                                                Rp. <span id="diskon">0</span>
                                            </div>

                                            <div class="col-sm-10 text-end"> Harus Dibayar : </div>
                                            <div class="col-sm-2 text-end">
                                                Rp. <span id="harus_bayar">0</span>
                                            </div>
                                        </div>
                                        <hr>

                                        <!-- button end -->
                                        <div class="row mt-4">
                                            <div class="col-sm-12 text-end">
                                                <?php if($data_transaksi[0]->payment_status == 'Belum Bayar') : ?> 
                                                    <button class="btn btn-primary" data-bs-toggle="modal" 
                                                        data-bs-target="#modal_pay"
                                                    > 
                                                        Bayar
                                                    </button>
                                                <?php else : ?>
                                                    <a href="<?= base_url('transaksi/printReceipt/'.$id_transaksi) ?>" class="btn btn-info" target="_blank">
                                                        Cetak Struk
                                                    </a>
                                                    <a href="javascript:swalPaid();" class="btn btn-success" >
                                                        Sudah Dibayar
                                                    </a>
                                                <?php endif; ?>
                                            </div>
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
        <div id="modal_pay" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Bayar Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="harga_awal" class="form-label">Harga Awal</label>
                                    <input class="form-control text-center" type="text" id="harga_awal" name="harga_awal" readonly/>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="diskon_awal" class="form-label">Diskon Awal</label>
                                    <input class="form-control text-center" type="text" id="diskon_awal" name="diskon_awal" readonly/>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="diskon_tambah" class="form-label">Tambah Diskon</label>
                                    <input class="form-control text-center" type="number" id="diskon_tambah" name="diskon_tambah"/>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="harga_akhir" class="form-label">Harus Dibayar</label>
                                    <input class="form-control text-center" type="text" id="harga_akhir" name="harga_akhir" readonly/>
                                </div>
                                <hr>
                                <div class="col-lg-12 mb-3">
                                    <label for="metode_bayar" class="form-label">Metode Pembayaran</label>
                                    <select class="form-control select2" id="metode_bayar" name="metode_bayar" >
                                        <option value="">Pilih Metode Bayar</option>
                                        <?php foreach ($data_payment_method as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="nominal_dibayar" class="form-label">Nominal bayar</label>
                                    <input class="form-control text-center" type="number" id="nominal_dibayar" name="nominal_dibayar"/>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="nominal_kembalian" class="form-label">Nominal Kembalian</label>
                                    <input class="form-control text-center" type="text" id="nominal_kembalian" name="nominal_kembalian" readonly/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_bayar" >
                                        Konfirmasi Bayar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal add -->
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

        <!-- modal edit -->
        <div id="modal_edit" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Jumlah Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-3 text-center">
                                    <h3>
                                        <span id="nama_edit"></span>
                                    </h3>
                                    <input type="hidden" id="id_edit" name="id_edit" />
                                    <input type="hidden" id="harga_edit" name="harga_edit" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="jumlah_edit" class="form-label">Jumlah</label>
                                    <input class="form-control text-center" type="number" id="jumlah_edit" name="jumlah_edit" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-primary ml-3" id="btn_konfirmasi_edit">
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
    let hargaAwal, diskonAwal;
    const idtransaksi = '<?= $id_transaksi ?>';
    const paymenStatus = '<?= $data_transaksi[0]->payment_status ?>';

    // Call the function when the document is ready
    $(document).ready(function() {
        mainDatatable();
    });

    // Initialize or reinitialize the DataTable
    function mainDatatable() {
        let centeredArra, orderableArray;
        // Destroy the existing DataTable instance if it exists
        if (mainTable) {
            mainTable.destroy();
        }

        if(paymenStatus === 'Belum Bayar'){
            centeredArra = [ 0, 2, 3, 4, 5, 6 ];
            orderableArray = [ 0, 6 ]
        }else{
            centeredArra = [ 0, 2, 3, 4, 5 ];
            orderableArray = [ 0 ]
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
                [5, 10, 15, -1],
                ['5', '10', '15', 'ALL']
            ],
            ajax: {
                "url": "<?= site_url('transaksi/ajax_get_transaksi_detail/'. $id_transaksi .'/'. $data_transaksi[0]->payment_status) ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                }
            },
            columnDefs: [
                { 
                    "targets": centeredArra,
                    "className": "text-center"
                },
                { 
                    "targets": orderableArray,
                    "orderable": false,
                },
            ],
        });

        updateSubtotal();
        calculateHarusBayar();
    }

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const thisData = $(this).data();
        const path = thisData['path'];
        const data = {
            kode: $('#kode').val(),
            nama: $('#nama').val(),
            deskripsi: $('#deskripsi').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Simpan Satuan dengan nama: '+$('#nama').val()+' ?', 
            'Disimpan!', 'Satuan dengan nama: '+$('#nama').val()+' berhasil disimpan.', 'modal_add'
        );
    });

    // delete
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('transaksi/delete_transaksi_detail') ?>";
        const data = {
            id_delete : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus tem '+thisData['nama']+' dari transaksi?', 
            'Dihapus!', 'Item '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit', function() {
        // fill value
        $('#id_edit').val($(this).data('id'));
        $('#harga_edit').val($(this).data('price'));
        $('#jumlah_edit').val($(this).data('quantity'));
        $('#nama_edit').text($(this).data('nama'));
                
        // Show the modal
        $('#modal_edit').modal('show');
    });

    // konfirmasi edit
    $(document).on('click', '#btn_konfirmasi_edit', function () {
        const thisData = $(this).data();
        const path = "<?= base_url('transaksi/edit_transaksi_detail_jumlah_item') ?>";
        const data = {
            id_edit: $('#id_edit').val(),
            quantity: $('#jumlah_edit').val(),
            subtotal: parseFloat($('#harga_edit').val()) * parseFloat($('#jumlah_edit').val())
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit jumlah item ?', 
            'Diedit!', 'Jumlah berhasil diedit.', 'modal_edit'
        );
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
        const path = "<?= base_url('transaksi/add_transaksi_detail') ?>";
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
            transaction_id: "<?= $id_transaksi ?>",
            transaction_detail: rowsData
        };

        updateSubtotal();
        
        loadQuestionalSwal(
            path, data, 'Tambah Item Transaksi ?', 
            'Ditambahkan!', 'Item baru berhasil ditambahkan pada transaksi ini', 'modal_add_item'
        );
    });

    // Function to calculate subtotal
    function updateSubtotal() {
        const path = "<?= site_url('transaksi/ajax_get_sub_total/'. $id_transaksi) ?>";
        const idTransaksi = "<?= $id_transaksi ?>"
        $.ajax({
            url: path, 
            method: 'POST', 
            data: { id_transaksi: idTransaksi },
            dataType: 'json',
            success: function (response) {
                $('#sub_total').text(thousandSeparator(response.subtotal, 0));
                calculateHarusBayar();
            },
            error: function () {
                console.log('Error occurred while retrieving subtotal.');
            }
        });
    }

    // calculate harus bayar
    function calculateHarusBayar(){
        var subTotal = parseInt(removeThousandSeparator($('#sub_total').text()));
        var diskon = parseInt(removeThousandSeparator($('#diskon').text()));

        var harus_bayar = subTotal - diskon;
        hargaAwal = subTotal;
        diskonAwal = diskon;

        $('#harus_bayar').text(thousandSeparator(harus_bayar, 0));
    }

    // on modal_pay show
    $('#modal_pay').on('shown.bs.modal', function () {
        $('#harga_awal').val(hargaAwal);
        $('#diskon_awal').val(diskonAwal);
        $('#harga_akhir').val(hargaAwal - diskonAwal);
    });

    // on input tambah diskon
    $('#diskon_tambah').on('input', function() {
        var inputedValue = parseFloat($(this).val());
        if (inputedValue < 0 || inputedValue === '' || isNaN(inputedValue)) {
            // If negative, set it to 0
            inputedValue = 0;
            $(this).val(inputedValue); // Update the input field value
        }

        $('#harga_akhir').val(hargaAwal - diskonAwal - inputedValue);
    });

    // on input tambah diskon
    $('#nominal_dibayar').on('input', function() {
        var inputedValue = parseFloat($(this).val());
        if (inputedValue < 0 || inputedValue === '' || isNaN(inputedValue)) {
            // If negative, set it to 0
            inputedValue = 0;
            $(this).val(inputedValue); // Update the input field value
        }

        $('#nominal_kembalian').val( inputedValue - $('#harga_akhir').val() );
    });

    // konfirmasi bayar
    $(document).on('click', '#btn_konfirmasi_bayar', function () {
        const path = "<?= base_url('transaksi/add_payment') ?>";
        const data = {
            id_transaksi: idtransaksi,
            nominal_awal: hargaAwal,
            diskon_basic: diskonAwal,
            diskon_tambahan: $('#diskon_tambah').val(),
            nominal_akhir: $('#harga_akhir').val(),
            nominal_bayar: $('#nominal_dibayar').val(),
            nominal_kembalian: $('#nominal_kembalian').val(),
            id_payment_method: $('#metode_bayar').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi Bayar ?', 
            'Diedit!', 'Pembayaran Berhasil', 'modal_pay'
        );
    });

    // sudah bayar swal
    function swalPaid(){
        Swal.fire({
            title: 'Invoice Ini Sudah Dibayar',
            icon: 'info',
            text: '',
            timer: 3000,
            confirmButtonColor: "#5664d2",
        })
    }

</script>
