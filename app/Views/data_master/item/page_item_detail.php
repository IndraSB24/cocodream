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
                                <input class="form-control" type="hidden" id="id_item_utama" name="id_item_utama" 
                                    value="<?= $id_item_utama ?>"
                                />
                                <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#modal_add"> 
                                    Tambah Data Formula
                                </button>
                            </div>
                        </div>
                        
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
                                                        <th class="text-center">Kode Item</th>
                                                        <th class="text-center">nama</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-center">Satuan</th>
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Item Formula</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <!-- bahan -->
                                <div class="col-lg-6 mb-3">
                                    <label for="item" class="form-label">Bahan</label>
                                    <select class="form-control select2" id="item" >
                                        <option value="">Pilih Bahan</option>
                                        <?php foreach ($data_item as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- jumlah -->
                                <div class="col-lg-4 mb-3">
                                    <label for="jumlah" class="form-label">Jumlah per satuan bahan</label>
                                    <input class="form-control" type="number" id="jumlah" />
                                </div>

                                <!-- satuan -->
                                <div class="col-sm-2 mb-3">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" id="satuan" class="form-control text-center" readonly/>
                                </div>
                            </div>

                            <!-- buttion -->
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
                        <form action="#" id="form_modal_edit" method="POST">
                            <!-- element -->
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="item_edit" class="form-label">Item</label>
                                    <select class="form-control" id="item_edit" name="item_edit" >
                                        <option value="">Pilih Item</option>
                                        <?php foreach ($data_item as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="jumlah_edit" class="form-label">Jumlah</label>
                                    <input class="form-control" type="number" id="jumlah_edit" name="jumlah_edit" />
                                </div>
                            </div>

                            <!-- button -->
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
    const idItemUtama = "<?= $id_item_utama ?>";
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
                "url": "<?= site_url('item_detail/ajax_get_list_item/'.$id_item_utama) ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                    id = idItemUtama;
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3, 4, 5 ],
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
        const nama = $('#item option:selected').text();
        const path = "<?= site_url('item_detail/add_item_detail') ?>";
        const data = {
            id_item_utama: idItemUtama,
            id_item: $('#item').val(),
            jumlah: $('#jumlah').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Tambahkan Item dengan nama: '+nama+' sebagai formula ?', 
            'Disimpan!', 'Item dengan nama: '+nama+' berhasil ditambahkan pada list formula.', 'modal_add'
        );
    });

    // delete
    $(document).on('click', '#btn_delete', function () {
        const thisData = $(this).data();
        const path = "<?= site_url('item/delete_item') ?>";
        const data = {
            id : thisData['id']
        };
        
        loadQuestionalSwal(
            path, data, 'Hapus Item dengan nama: '+thisData['nama']+' ?', 
            'Dihapus!', 'Item dengan nama: '+thisData['nama']+' berhasil dihapus.', ''
        );
    });

    // load edit modal
    $(document).on('click', '#btn_edit', function() {
        var idItem = $(this).data('id');
        const path = "<?= site_url('item/ajax_get_item_data') ?>";
        const kode_urut = $(this).data('kode_urut');
        
        $.ajax({
            url: path,
            method: 'POST',
            data: { id_item: idItem },
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#edit_id').val(idItem);
                $('#kode_item_edit').val(response.kode_item);
                $('#barcode_edit').val(response.barcode);
                $('#nama_edit').val(response.nama);
                $('#kategori_edit').val(response.id_kategori_item).trigger('change');
                $('#jenis_edit').val(response.id_kategori_jenis).trigger('change');
                $('#brand_edit').val(response.id_brand).trigger('change');
                $('#supplier_edit').val(response.id_supplier).trigger('change');
                $('#stok_minimum_edit').val(response.stok_minimum);
                $('#satuan_edit').val(response.id_satuan).trigger('change');
                
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
        const path = "<?= site_url('item/edit_item') ?>";
        const data = {
            edit_id: $('#edit_id').val(),
            kode_item: $('#kode_item_edit').val(),
            barcode: $('#barcode_edit').val(),
            nama: $('#nama_edit').val(),
            id_kategori_jenis: $('#jenis_edit').val(),
            id_satuan: $('#satuan_edit').val(),
            id_kategori_item: $('#kategori_edit').val(),
            id_brand: $('#brand_edit').val(),
            id_supplier: $('#supplier_edit').val(),
            stok_minimum: $('#stok_minimum_edit').val(),
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit Item dengan Kode: '+ $('#kode_item_edit').val() +' ?', 
            'Diedit!', 'Item dengan kode: '+ $('#kode_item_edit').val() +' berhasil diedit.', 'modal_edit'
        );
    });

    // set input value change by selected item
    $('#item').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var idItem = selectedOption.val();

        $.ajax({
            url: "<?= base_url('item/ajax_get_item_data') ?>",
            type: 'POST',
            data: { id_item: idItem },
            success: function(response) {
                $('#satuan').val(response.nama_satuan);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching additional data:', error);
            }
        });
    });

    // on modal_add_item hidden
    $('#modal_add').on('hidden.bs.modal', function () {
        // reset dropdown produk
        $('#item').val('');

        // reset other elem
        resetElement(['satuan', 'jumlah'])
    });

</script>
