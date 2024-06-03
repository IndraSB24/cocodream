<?= $this->include('partials/main') ?>

    <head>
        
        <?= $title_meta ?>

        <?= $this->include('partials/custom-css') ?>
        <?= $this->include('partials/head-css') ?>

        <style>
            .card-body {
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            .tab-content {
                flex-grow: 1;
                overflow: auto;
            }

            .row.overflow-auto {
                flex-grow: 1;
                overflow: auto;
            }
        </style>

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
                            <!-- Items List -->
                            <div class="col-md-6">
                                <div class="card" style="height: 600px;">
                                    <div class="card-header bg-success">
                                        <ul class="nav nav-tabs card-header-tabs" id="item-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="makanan-tab" data-bs-toggle="tab" href="#makanan" role="tab" aria-controls="makanan" aria-selected="false">Makanan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="minuman-tab" data-bs-toggle="tab" href="#minuman" role="tab" aria-controls="minuman" aria-selected="false">Minuman</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="item-tab-content">
                                            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                                <div class="row overflow-auto" id="item-list-all">
                                                    <?php foreach ($items as $item): ?>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="card item-box" data-id="<?= $item['id']; ?>" data-name="<?= $item['nama']; ?>" data-price="<?= $item['item_price']; ?>">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><?= $item['nama']; ?></h5>
                                                                    <p class="card-text">Rp. <?= $item['item_price']; ?></p>
                                                                    <button class="btn btn-primary add-to-cart">Tambahkan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="makanan" role="tabpanel" aria-labelledby="makanan-tab">
                                                <div class="row overflow-auto" id="item-list-makanan">
                                                    <?php foreach ($items as $item): ?>
                                                        <?php if ($item['nama_jenis'] == 'makanan'): ?>
                                                            <div class="col-md-4 mb-3">
                                                                <div class="card item-box" data-id="<?= $item['id']; ?>" data-name="<?= $item['nama']; ?>" data-price="<?= $item['item_price']; ?>">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title"><?= $item['nama']; ?></h5>
                                                                        <p class="card-text">Rp. <?= $item['item_price']; ?></p>
                                                                        <button class="btn btn-primary add-to-cart">Tambahkan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="minuman" role="tabpanel" aria-labelledby="minuman-tab">
                                                <div class="row overflow-auto" id="item-list-minuman">
                                                    <?php foreach ($items as $item): ?>
                                                        <?php if ($item['nama_jenis'] == 'minuman'): ?>
                                                            <div class="col-md-4 mb-3">
                                                                <div class="card item-box" data-id="<?= $item['id']; ?>" data-name="<?= $item['nama']; ?>" data-price="<?= $item['item_price']; ?>">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title"><?= $item['nama']; ?></h5>
                                                                        <p class="card-text">Rp. <?= $item['item_price']; ?></p>
                                                                        <button class="btn btn-primary add-to-cart">Tambahkan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Items -->
                            <div class="col-md-6">
                                <div class="card" style="height: 600px;">
                                    <div class="card-header bg-success">
                                        <h4 class="mb-3">Cart</h4>
                                    </div>
                                    <div class="card-body overflow-auto">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="cart-table">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Cart items will be appended here dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <h5>Total: Rp. <span id="cart-total"> <?= thousand_separator(0) ?> </span></h5>
                                        <button class="btn btn-success" id="btn_bayar">Bayar</button>
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

    $(document).ready(function () {
        let cart = [];

        function updateCart() {
            const $cartTableBody = $('#cart-table tbody');
            $cartTableBody.empty();
            let total = 0;
            cart.forEach(item => {
                const itemTotal = item.quantity * item.price;
                total += itemTotal;
                $cartTableBody.append(`
                    <tr>
                        <td>${item.name}</td>
                        <td>
                            <input type="text" class="form-control quantity-input text-center p-0" data-id="${item.id}" value="${item.quantity}">
                        </td>
                        <td>${item.price.toLocaleString('id-ID')}</td>
                        <td>${itemTotal.toLocaleString('id-ID')}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="${item.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
            $('#cart-total').text(total.toLocaleString('id-ID'));

            // Initialize TouchSpin on quantity inputs
            $(".quantity-input").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
            }).off('change').on('change', function () {
                const itemId = $(this).data('id');
                const newQuantity = parseInt($(this).val());
                const item = cart.find(item => item.id === itemId);
                if (item && newQuantity > 0) {
                    item.quantity = newQuantity;
                    updateCart();
                }
            });
        }

        $('#item-list').on('click', '.add-to-cart', function () {
            const $card = $(this).closest('.item-box');
            const itemId = $card.data('id');
            const itemName = $card.data('name');
            const itemPrice = parseFloat($card.data('price'));

            const existingItem = cart.find(item => item.id === itemId);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ id: itemId, name: itemName, price: itemPrice, quantity: 1 });
            }
            updateCart();
        });

        $('#cart-table').on('click', '.remove-from-cart', function () {
            const itemId = $(this).data('id');
            cart = cart.filter(item => item.id !== itemId);
            updateCart();
        });
    });

    // btn simpan
    $(document).on('click', '#btn_simpan', function () {
        const path = "<?= base_url('transaksi/add_transaksi') ?>";
        let rowsData = [];

        $('#cart-table tbody tr').each(function() {
            let rowData = {};
            $(this).find('td').each(function(index) {
                switch(index) {
                    case 0:
                        rowData.nama = $(this).text();
                        break;
                    case 1:
                        rowData.jumlah = parseFloat($(this).find('.quantity-input').val());
                        break;
                    case 2:
                        rowData.harga = parseFloat($(this).text().replace(/,/g, ''));
                        break;
                    case 3:
                        rowData.total = parseFloat($(this).text().replace(/,/g, ''));
                        break;
                    case 4:
                        rowData.id_item = $(this).find('.remove-from-cart').data('id');
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

        // Assuming you have a function loadQuestionalSwal defined to handle the request
        loadQuestionalSwal(
            path, data, 'Tambah transaksi ?', 
            'Disimpan!', 'Transaksi baru berhasil ditambahkan', 'modal_add'
        );
    });

</script>
