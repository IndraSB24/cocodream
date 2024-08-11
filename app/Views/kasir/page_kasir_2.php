<?php
    function renderItemCard($item) {
        ob_start(); // Start output buffering
        ?>
        <div class="col-md-4 mb-3">
            <div class="card item-box" 
                data-id="<?= $item['id']; ?>"
                data-name="<?= $item['nama']; ?>"
                data-price="<?= $item['item_price']; ?>"
                data-unit="<?= $item['nama_satuan']; ?>"
                data-is_has_formula="<?= $item['is_has_formula']; ?>"
            >
                <div class="card-body">
                    <img src="<?= base_url('upload/item_pict/'.$item['image_filename']); ?>" alt="<?= $item['nama']; ?>" 
                        class="img-fluid mb-3" style="max-width: 100%; height: 100px"
                    >    
                    <p class="card-text"><?= $item['nama']; ?></p>
                    <p class="card-text">Rp. <?= $item['item_price']; ?></p>
                    <button class="btn btn-primary add-to-cart">Tambah</button>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean(); // Return the buffered output
    }
?>

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
                                                        <?= renderItemCard($item); ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="makanan" role="tabpanel" aria-labelledby="makanan-tab">
                                                <div class="row overflow-auto" id="item-list-makanan">
                                                    <?php foreach ($items as $item): ?>
                                                        <?php if ($item['nama_jenis'] == 'makanan'): ?>
                                                            <?= renderItemCard($item); ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="minuman" role="tabpanel" aria-labelledby="minuman-tab">
                                                <div class="row overflow-auto" id="item-list-minuman">
                                                    <?php foreach ($items as $item): ?>
                                                        <?php if ($item['nama_jenis'] == 'minuman'): ?>
                                                            <?= renderItemCard($item); ?>
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
                                            <table class="table" id="cart-table">
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
                                        <input type="hidden" id="cart_total_value"/>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_pay">
                                            Bayar
                                        </button>
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

        <!-- modal pay -->
        <div id="modal_pay" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-light" id="myLargeModalLabel">Bayar Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_modal_add" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-1 text-center">
                                    <span>Total Belanja</span>
                                    <br>
                                    <h1 id="harga_awal_show"></h1>
                                    <input type="hidden" id="harga_awal">
                                    <input type="hidden" id="harga_akhir">
                                </div>
                                <hr>
                                <!-- uang konsumen -->
                                <div class="col-lg-6 mb-3">
                                    <label for="nominal_dibayar" class="form-label">Uang Konsumen</label>
                                    <input class="form-control text-center thousand-separator bg-info text-white" type="number" id="nominal_dibayar" name="nominal_dibayar"/>
                                    <input type="hidden" id="nominal_dibayar_number">
                                </div>
                                <!-- fixed nominal -->
                                <div class="col-lg-6 mb-3">
                                    <label for="nominal_options" class="form-label">Pilihan Nominal</label>
                                    <div id="nominal_options" class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(1000)">1.000</button>
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(2000)">2.000</button>
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(5000)">5.000</button>
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(10000)">10.000</button>
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(20000)">20.000</button>
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(50000)">50.000</button>
                                        <button type="button" class="btn btn-secondary" onclick="addNominal(100000)">100.000</button>
                                        <button type="button" class="btn btn-success" onclick="setExactAmount()">Uang Pas</button>
                                    </div>
                                </div>
                                <!-- diskon -->
                                <div class="col-lg-6 mb-3">
                                    <label for="diskon_tambah" class="form-label">Diskon</label>
                                    <input class="form-control text-center thousand-separator bg-info text-white" type="number" id="diskon_tambah" name="diskon_tambah"/>
                                    <input type="hidden" id="diskon_tambah_number">
                                </div>
                                <!-- payment method -->
                                <div class="col-lg-6 mb-3">
                                    <label for="metode_bayar" class="form-label">Metode Pembayaran</label>
                                    <select class="form-control" id="metode_bayar" name="metode_bayar" >
                                        <?php foreach ($data_payment_method as $item): ?>
                                            <option value="<?= $item->id ?>">
                                                <?= $item->detail ? $item->name.' - '.$item->detail : $item->name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <!-- kembalian -->
                                <div class="col-lg-6 mb-3">
                                    <label for="nominal_kembalian" class="form-label">Kembalian</label>
                                    <input class="form-control text-center" type="text" id="nominal_kembalian_show" readonly/>
                                    <input type="hidden" id="nominal_kembalian" />
                                </div>
                                <!-- cahnnel distribusi -->
                                <div class="col-lg-6 mb-3 d-none">
                                    <label for="distribution_channel" class="form-label">Channel Distribusi</label>
                                    <select class="form-control" id="distribution_channel" name="distribution_channel" >
                                        <?php foreach ($data_distribution_channel as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
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

        <!-- JAVASCRIPT -->
        <?= $this->include('partials/vendor-scripts') ?>
        <?= $this->include('partials/custom-page-scripts') ?>

    </body>

</html>

<script>

    const thousandSeparatorInputs = document.querySelectorAll('.thousand-separator');
    thousandSeparatorInputs.forEach(input => {
        input.addEventListener('input', function(event) {
            let inputValue = event.target.value;
            let cursorPosition = event.target.selectionStart;

            // Save the initial length of the input
            let initialLength = inputValue.length;

            // Remove non-numeric characters
            inputValue = keepOnlyNumbers(inputValue);

            // Add thousand separators
            const formattedValue = thousandSeparator(inputValue);

            // Update the input value
            event.target.value = formattedValue;

            // Calculate the new cursor position
            let newLength = formattedValue.length;
            cursorPosition += newLength - initialLength;

            // Set the cursor position
            event.target.setSelectionRange(cursorPosition, cursorPosition);
        });
    });

    $(document).ready(function () {
        let cart = [];

        // Handle adding items to cart
        $('.add-to-cart').on('click', function() {
            const itemBox = $(this).closest('.item-box');
            const itemId = itemBox.data('id');
            const itemName = itemBox.data('name');
            const itemUnit = itemBox.data('unit');
            const itemIsHasFormula = itemBox.data('is_has_formula');
            const itemPrice = parseFloat(itemBox.data('price'));
            const itemQuantity = 1; // Default quantity to 1

            // Calculate item total
            const itemTotal = itemPrice * itemQuantity;

            // Append item to cart table
            $('#cart-table tbody').append(`
                <tr>
                    <td>${itemName}</td>
                    <td><input type="number" class="form-control quantity-input text-center p-0" value="${itemQuantity}" min="1"></td>
                    <td>Rp. ${itemPrice}</td>
                    <td>Rp. ${itemTotal}</td>
                    <td>
                        <input type="hidden" name="id_item" value="${itemId}">
                        <input type="hidden" name="item_unit" value="${itemUnit}">
                        <input type="hidden" name="item_is_has_formula" value="${itemIsHasFormula}">
                        <button class="btn btn-danger btn-sm remove-from-cart">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            // Initialize TouchSpin on quantity inputs
            // $(".quantity-input").TouchSpin({
            //     min: 1,
            //     max: 100,
            //     step: 1,
            //     decimals: 0,
            //     boostat: 5,
            //     maxboostedstep: 10,
            // });

            updateCartTotal();
        });

        // Handle removing items from cart
        $(document).on('click', '.remove-from-cart', function() {
            $(this).closest('tr').remove();
            updateCartTotal();
        });

        // Handle quantity change
        $(document).on('input', '.quantity-input', function() {
            const row = $(this).closest('tr');
            const itemPrice = parseFloat(row.find('td:nth-child(3)').text().replace(/Rp\.|,/g, ''));
            const itemQuantity = $(this).val();
            const itemTotal = itemPrice * itemQuantity;

            row.find('td:nth-child(4)').text('Rp. ' + itemTotal);
            updateCartTotal();
        });

        // Update cart total
        function updateCartTotal() {
            let total = 0;
            $('#cart-table tbody tr').each(function() {
                const itemTotal = parseFloat($(this).find('td:nth-child(4)').text().replace(/Rp\.|,/g, ''));
                total += itemTotal;
            });

            $('#cart-total').text(thousandSeparator(total));
            $('#cart_total_value').val(total);
        }
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
                        rowData.id_item = $(this).find('.remove-from-cart').data('idItem');
                        rowData.unit = $(this).find('.remove-from-cart').data('unitItem');
                        break;
                }
            });
            rowsData.push(rowData);
        });

        const data = {
            transaction_detail: rowsData,
            nominal_awal: $('#harga_awal').val(),
            diskon_tambahan: $('#diskon_tambah').val(),
            nominal_akhir: $('#harga_akhir').val(),
            nominal_bayar: $('#nominal_dibayar').val(),
            nominal_kembalian: $('#nominal_kembalian').val(),
            id_payment_method: $('#metode_bayar').val()
        };

        // Assuming you have a function loadQuestionalSwal defined to handle the request
        loadQuestionalSwal(
            path, data, 'Tambah transaksi ?', 
            'Disimpan!', 'Transaksi baru berhasil ditambahkan', 'modal_add'
        );
    });

    // on modal_pay show
    $('#modal_pay').on('shown.bs.modal', function () {
        clearFieldValue(['nominal_kembalian', 'nominal_dibayar', 'diskon_tambah']);
        
        const cartTotal = $('#cart_total_value').val();
        $('#harga_awal').val(cartTotal);
        $('#harga_akhir').val(cartTotal);
        $('#harga_awal_show').text('Rp. ' + thousandSeparator(cartTotal));
        $('#harga_akhir_show').val(thousandSeparator(cartTotal));
    });


    // on input tambah diskon
    $('#diskon_tambah').on('input', function() {
        var inputedValue = parseFloat( removeThousandSeparator($(this).val()) );
        if (inputedValue < 0 || inputedValue === '' || isNaN(inputedValue)) {
            // If negative, set it to 0
            inputedValue = 0;
            $(this).val(inputedValue); // Update the input field value
        }

        const hargaAwal = $('#harga_awal').val();
        $('#harga_akhir').val(hargaAwal - inputedValue);
        $('#harga_akhir_show').val(thousandSeparator(hargaAwal - inputedValue));
        $('#diskon_tambah_number').val(inputedValue);
    });

    // on input tambah diskon
    $('#nominal_dibayar').on('input', function() {
        var inputedValue = parseFloat( removeThousandSeparator($(this).val()) );
        if (inputedValue < 0 || inputedValue === '' || isNaN(inputedValue)) {
            // If negative, set it to 0
            inputedValue = 0;
            $(this).val(inputedValue); // Update the input field value
        }

        $('#nominal_kembalian').val( inputedValue - $('#harga_akhir').val() );
        $('#nominal_kembalian_show').val( thousandSeparator(inputedValue - $('#harga_akhir').val()) );
        $('#nominal_dibayar_number').val(inputedValue);
    });

    // konfirmasi bayar
    $(document).on('click', '#btn_konfirmasi_bayar', function () {
        const path = "<?= base_url('transaksi/add_transaksi') ?>";
        var rowsData = [];

        // Iterate over each row in the table
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
                        rowData.harga = parseFloat($(this).text().replace(/Rp\.\s?|,/g, ''));
                        break;
                    case 3:
                        rowData.total = parseFloat($(this).text().replace(/Rp\.\s?|,/g, ''));
                        break;
                    case 4:
                        rowData.id_item = $(this).find('input[name="id_item"]').val();
                        rowData.unit = $(this).find('input[name="item_unit"]').val();
                        rowData.is_has_formula = $(this).find('input[name="item_is_has_formula"]').val();
                        break;
                }
            });
            rowsData.push(rowData);
        });

        const data = {
            transaction_detail: rowsData,
            nominal_awal: $('#harga_awal').val(),
            diskon_tambahan: $('#diskon_tambah_number').val(),
            nominal_akhir: $('#harga_akhir').val(),
            nominal_bayar: $('#nominal_dibayar_number').val(),
            nominal_kembalian: $('#nominal_kembalian').val(),
            id_payment_method: $('#metode_bayar').val(),
            id_distribution_channel: $('#distribution_channel').val()
        };
        
        loadQuestionalSwalResetElement(
            path, data, 'Konfirmasi Bayar ?', 
            'Dibayar!', 'Pembayaran Berhasil', 'modal_pay'
        );
    });

    function resetTheseElement(){
        resetElement(
            '#cart-table tbody'
        )

        $('#cart-total').text('0')
    }

</script>
