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
                                                <div class="col-lg-4 mb-3">
                                                    <label for="filter_nama" class="form-label">Kategori</label>
                                                    <select class="form-control select2" data-trigger name="filter_kategori" id="filter_kategori">
                                                    <option value="">Pilih Kategori</option>
                                                        <?php
                                                            foreach($data_kategori_item as $row){
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
                                                    <label for="filter_nama" class="form-label">Jenis</label>
                                                    <select class="form-control select2" data-trigger name="filter_jenis" id="filter_jenis">
                                                    <option value="">Pilih Jenis</option>
                                                        <?php
                                                            foreach($data_jenis_item as $row){
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
                                                    <label for="filter_kota" class="form-label">Brand</label>
                                                    <select class="form-control select2" data-trigger name="filter_brand" id="filter_brand">
                                                        <option value="">Pilih Brand</option>
                                                        <?php
                                                            foreach($data_brand as $row){
                                                                echo '
                                                                    <option value="'.$row->id.'"> '.
                                                                        $row->nama.
                                                                    '</option>
                                                                ';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-12" style="text-align: right">
                                                    <a class="btn btn-danger ml-3" onClick="reloadPage()"> Reset </a>
                                                    <a id="btn-filter" class="btn btn-dark ml-3"> Filter </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#modal_add"> 
                                    Tambah Data
                                </button>
                                <a href="<?= base_url('item_pricing/index') ?>" class="btn btn-info">
                                    Data Harga Jual 
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <div class="table-responsive"> -->
                                            <table id="main_table" class="table table-bordered nowrap" 
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Kode Item</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Jenis</th>
                                                        <th class="text-center">Satuan</th>
                                                        <th class="text-center">Harga Jual Aktif</th>
                                                        <th class="text-center">Detail</th>
                                                        <th class="text-center">Action</th>
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Tambah Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="kode_item" class="form-label">Kode Item</label>
                                    <input class="form-control" type="text" id="kode_item" name="kode_item" placeholder="Kode Item" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <select class="form-control select2" id="jenis" name="jenis" >
                                        <option value="">Pilih Jenis</option>
                                        <?php foreach ($data_jenis_item as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <select class="form-control select2" id="satuan" name="satuan">
                                        <option value="">Pilih Satuan</option>
                                        <?php foreach ($data_satuan as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="item_image" class="form-label">Gambar Produk</label>
                                    <div >
                                        <label for="item_image" id="up_item_image" class="btn btn-info">Choose File</label>
                                        <input name="item_image" id="item_image" type="file" multiple="multiple" style="display: none;" />
                                        &nbsp;<span id="item_image_filename">No File Choosen</span>
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

        <!-- modal Edit -->
        <div id="modal_edit" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Edit Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_edit" method="POST">
                        <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="kode_item_edit" class="form-label">Kode Item</label>
                                    <input class="form-control" type="text" id="kode_item_edit" name="kode_item_edit" placeholder="Kode Item" />
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="jenis_edit" class="form-label">Jenis</label>
                                    <select class="form-control select2" id="jenis_edit" name="jenis_edit" >
                                        <option value="">Pilih Jenis</option>
                                        <?php foreach ($data_jenis_item as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="nama_edit" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="nama_edit" name="nama_edit" placeholder="Nama" />
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="satuan_edit" class="form-label">Satuan</label>
                                    <select class="form-control select2" id="satuan_edit" name="satuan_edit">
                                        <option value="">Pilih Satuan</option>
                                        <?php foreach ($data_satuan as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="item_image_edit" class="form-label">Gambar Produk</label>
                                    <div >
                                        <label for="item_image_edit" id="up_item_image" class="btn btn-info">Choose File</label>
                                        <input name="item_image_edit" id="item_image_edit" type="file" multiple="multiple" style="display: none;" />
                                        &nbsp;<span id="item_image_filename">No File Choosen</span>
                                    </div>
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
                "url": "<?= site_url('item/ajax_get_list_item') ?>",
                "type": "POST",
                "data": function (data) {
                    data.searchValue = $('#main_table_filter input').val();
                    data.filter_kategori = $('#filter_kategori').val();
                    data.filter_jenis = $('#filter_jenis').val();
                    data.filter_brand = $('#filter_brand').val();
                }
            },
            columnDefs: [
                { 
                    "targets": [ 0, 1, 2, 3, 5, 6, 7 ],
                    "className": "text-center"
                },
                { 
                    "targets": [ 0, 7 ],
                    "orderable": false,
                },
            ],
        });
    }

    // btn filter
    $('#btn-filter').click(function(){ 
        mainDatatable(); 
    });

    // filename set
    $('#item_image').change(function() {
        var fileInput = $(this);
        var fileName = fileInput.val().split('\\').pop();
        $('#item_image_filename').text("File Choosen: " + fileName);
    });

    // simpan
    $(document).on('click', '#btn_simpan', function () {
        const path = "<?= site_url('item/add_item') ?>";
        var formData = new FormData();
        $('#item_image_filename').text("No File Choosen");

        // Append the file to formData
        var i = $('#item_image'),
            file = i[0].files[0];
        formData.append('file', file);

        // Append other form data
        formData.append('kode_item', $('#kode_item').val());
        formData.append('nama', $('#nama').val());
        formData.append('id_kategori_jenis', $('#jenis').val());
        formData.append('id_satuan', $('#satuan').val());
        
        loadQuestionalSwalFormData(
            path, formData, 'Tambahkan Item dengan nama: '+$('#nama').val()+' ?', 
            'Disimpan!', 'Item dengan nama: '+$('#nama').val()+' berhasil ditambahkan.', 'modal_add'
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
            stok_minimum: $('#stok_minimum_edit').val()
        };
        
        loadQuestionalSwal(
            path, data, 'Konfirmasi edit Item dengan Kode: '+ $('#kode_item_edit').val() +' ?', 
            'Diedit!', 'Item dengan kode: '+ $('#kode_item_edit').val() +' berhasil diedit.', 'modal_edit'
        );
    });

    // on modal_add hide
    $('#modal_add').on('hidden.bs.modal', function () {
        // Clear form fields
        clearFieldValue([
            'kode_item', 'nama', 'jenis', 'satuan', 'item_image'
        ]);

        $('#item_image_filename').text("No File Choosen");
    });

</script>
