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
                            <!-- Items List -->
                            <div class="col-md-6">
                                <h4 class="mb-3">Items</h4>
                                <div class="row" id="item-list">
                                    <?php foreach ($items as $item): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="card item-box" data-id="<?= $item['id']; ?>" data-name="<?= $item['nama']; ?>" data-price="<?= $item['item_price']; ?>">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $item['nama']; ?></h5>
                                                    <p class="card-text">Price: $<?= $item['item_price']; ?></p>
                                                    <button class="btn btn-primary add-to-cart">Add to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Selected Items -->
                            <div class="col-md-6">
                                <h4 class="mb-3">Cart</h4>
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
                                <div class="text-right">
                                    <h5>Total: $<span id="cart-total">0.00</span></h5>
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
    document.addEventListener('DOMContentLoaded', function () {
        let cart = [];

        function updateCart() {
            const cartTableBody = document.querySelector('#cart-table tbody');
            cartTableBody.innerHTML = '';
            let total = 0;
            cart.forEach(item => {
                const itemTotal = item.quantity * item.price;
                total += itemTotal;
                cartTableBody.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>
                            <input type="number" class="form-control quantity-input" data-id="${item.id}" value="${item.quantity}" min="1">
                        </td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>$${itemTotal.toFixed(2)}</td>
                        <td><button class="btn btn-danger btn-sm remove-from-cart" data-id="${item.id}">Remove</button></td>
                    </tr>
                `;
            });
            document.getElementById('cart-total').textContent = total.toFixed(2);
        }

        document.getElementById('item-list').addEventListener('click', function (e) {
            if (e.target.classList.contains('add-to-cart')) {
                const card = e.target.closest('.item-box');
                const itemId = card.dataset.id;
                const itemName = card.dataset.name;
                const itemPrice = parseFloat(card.dataset.price);

                const existingItem = cart.find(item => item.id === itemId);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({ id: itemId, name: itemName, price: itemPrice, quantity: 1 });
                }
                updateCart();
            }
        });

        document.getElementById('cart-table').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-from-cart')) {
                const itemId = e.target.dataset.id;
                cart = cart.filter(item => item.id !== itemId);
                updateCart();
            }
        });

        document.getElementById('cart-table').addEventListener('change', function (e) {
            if (e.target.classList.contains('quantity-input')) {
                const itemId = e.target.dataset.id;
                const newQuantity = parseInt(e.target.value);
                const item = cart.find(item => item.id === itemId);
                if (item && newQuantity > 0) {
                    item.quantity = newQuantity;
                    updateCart();
                }
            }
        });
    });
</script>