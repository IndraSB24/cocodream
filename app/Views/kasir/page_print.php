<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Cetak Printer Thermal</title>
    <style>
        @page {
            size: 58mm auto; /* Specify the page size for the thermal printer */
            margin: 0; /* Remove default margins */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .receipt {
            width: 58mm; /* Set width for thermal printer */
            padding: 5mm;
            border: 1px solid #ddd;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 5mm;
            margin-bottom: 5mm;
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        .content {
            font-size: 12px;
        }

        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 5mm;
            margin-top: 5mm;
        }

        .footer p {
            font-size: 12px;
        }

        .dashed-line {
            border-top: 1px dashed #000;
            margin: 5mm 0;
        }

        tfoot {
            margin-top: 20mm;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <img src="<?= base_url('assets/images/logo-dark.png') ?>" style="height: 100px; width: auto;">
            <h2>Cocodream</h2>
            <p>
                <?= $dataTransaksi[0]->entitas_address ?>
                <br>Kota Pekanbaru, Riau 28289
                <br>Telepon: +62 <?= $dataTransaksi[0]->entitas_phone ?>
            </p>
        </div>
        <div class="content">
            <!-- some detail -->
            <p><strong><center><h4><?= $invoice ?></h4></center></strong></p>
            <p><strong>Waktu:</strong> <?= $dataTransaksi[0]->transaction_date ?></p>
            <p><strong>Pelanggan:</strong> <?= $dataTransaksi[0]->nama_pasien ?> </p>
            <div class="dashed-line"></div>

            <!-- trans detail -->
            <table width="100%">
                <!-- item detail -->
                <thead>
                    <tr>
                        <th align="left">Item</th>
                        <th align="right">Jumlah</th>
                        <th align="right">Harga</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $totalPrice = 0;
                        foreach ($detailTransaksi as $key => $value) {
                            $totalPrice += $value->subtotal;
                            echo '
                                <tr>
                                    <td>'.$value->nama_item.'</td>
                                    <td align="right">'.$value->quantity.'</td>
                                    <td align="right">Rp. '.thousand_separator($value->subtotal).'</td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>

                <!-- payment detail -->
                <tfoot >
                    <tr>
                        <td></td>
                        <td align="right"><strong>Total :</strong></td>
                        <td align="right">
                            <strong>
                                Rp. <?= thousand_separator($totalPrice) ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><strong>Diskon :</strong></td>
                        <td align="right">
                            <strong>
                                Rp. <?= thousand_separator($detailBayar[0]->diskon_basic + $detailBayar[0]->diskon_tambahan) ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><strong>Tunai :</strong></td>
                        <td align="right">
                            <strong>
                                Rp. <?= thousand_separator($detailBayar[0]->nominal_bayar) ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><strong>Kembali :</strong></td>
                        <td align="right">
                            <strong>
                                Rp. <?= thousand_separator($detailBayar[0]->nominal_kembalian) ?>
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda</p>
        </div>
    </div>
</body>
</html>

<script>
    console.log(<?= json_encode($dataTransaksi) ?>, 'data transaksi');
    console.log(<?= json_encode($detailTransaksi) ?>, 'detail transaksi');
    console.log(<?= json_encode($detailBayar) ?>, 'detail bayar');
    
</script>
