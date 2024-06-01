<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_transaksi;
use App\Models\Model_kategori;
use App\Models\Model_pasien;
use App\Models\Model_transaksi_detail;
use App\Models\Model_transaksi_payment;

use App\Models\Model_item_transaksi_stock;
use Escpos\PrintConnectors\NetworkPrintConnector;
use Escpos\CapabilityProfile;
use Escpos\Printer;

// // require_once APPPATH . 'ThirdParty/Mike42/Escpos/Printer.php';
// // require_once APPPATH . 'ThirdParty/Mike42/Escpos/PrintConnectors/NetworkPrintConnector.php';
// // require_once APPPATH . 'ThirdParty/Mike42/Escpos/PrintConnectors/FilePrintConnector.php';



class Test_print extends Controller
{
    protected $Model_transaksi, $Model_kategori, $Model_pasien, $Model_transaksi_detail, $Model_transaksi_payment,
        $Model_item_transaksi_stock;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_kategori = new Model_kategori();
        $this->Model_pasien = new Model_pasien();
        $this->Model_transaksi_detail = new Model_transaksi_detail();
        $this->Model_transaksi_payment = new Model_transaksi_payment();
        $this->Model_item_transaksi_stock = new Model_item_transaksi_stock();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Transaksi']),
			'page_title' => view('partials/page-title', ['title' => 'Kasir', 'pagetitle' => 'List Transaksi']),
            'data_payment_method' => $this->Model_kategori->get_payment_method(),
            'data_payment_status' => $this->Model_kategori->get_payment_status(),
            'data_registration_status' => $this->Model_kategori->get_registration_status(),
            'data_pasien' => $this->Model_pasien->findAll()
		];
        return view('kasir/page_list_kasir', $data);
    }

    // show detail transaksi
    public function show_detail_transaksi($id_transaksi){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Detail Transaksi']),
			'page_title' => view('partials/page-title', ['title' => 'Kasir', 'pagetitle' => 'Detail Transaksi']),
            'data_payment_method' => $this->Model_kategori->get_payment_method(),
            'data_payment_status' => $this->Model_kategori->get_payment_status(),
            'data_registration_status' => $this->Model_kategori->get_registration_status(),
            'data_transaksi' => $this->Model_transaksi->get_by_id($id_transaksi),
            'id_transaksi' => $id_transaksi,
            'invoice' => generate_general_code('INV', $id_transaksi, 6)
		];
        return view('kasir/page_transaksi_detail', $data);
    }
	
    // add ==================================================================================================
    public function add_transaksi(){
        // insert transaction
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'id_pasien', 'transaction_date'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $insertDataId = $this->Model_transaksi->insertWithReturnId($data);

        if ($insertDataId) {

            $transactionDetailData = $this->request->getPost('transaction_detail');
            // $transactionDetails = json_decode($transactionDetailData, true);

            if (!empty($transactionDetailData) && is_array($transactionDetailData)) {
                foreach ($transactionDetailData as $transactionDetail) {
                    // insert transaksi detail
                    $payload_transaction_detail = [
                        'id_transaksi' =>  $insertDataId,
                        'id_item' => $transactionDetail['id_item'],
                        'quantity' => $transactionDetail['jumlah'],
                        'price' => $transactionDetail['harga'],
                        'subtotal' => $transactionDetail['total']
                    ];
                    $this->Model_transaksi_detail->save($payload_transaction_detail);

                    // insert transaksi stock
                    $payload_add_transaksi_stock = [
                        'id_item' => $transactionDetail['id_item'],
                        'jumlah' => -$transactionDetail['jumlah'], 
                        'jenis' => 'keluar', 
                        'kegiatan' => 'penjualan kasir', 
                        'id_kegiatan' => $insertDataId, 
                        'tanggal_kegiatan' => date("Y-m-d"),
                        'id_entitas' => sess_activeEntitasId(),
                        'created_by' => sess_activeUserId()
                    ];
                    $this->Model_item_transaksi_stock->addTransaksiStock($payload_add_transaksi_stock);
                }
            }
        
            $response = [
                'success' => true
            ];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // add transaksi detail =================================================================================
    public function add_transaksi_detail(){
        $transactionDetailData = $this->request->getPost('transaction_detail');
        $transaction_id = $this->request->getPost('transaction_id');
        
        if (!empty($transactionDetailData) && is_array($transactionDetailData)) {
            foreach ($transactionDetailData as $transactionDetail) {
                $payload_transaction_detail = [
                    'id_transaksi' =>  $transaction_id,
                    'id_item' => $transactionDetail['id_item'],
                    'quantity' => $transactionDetail['jumlah'],
                    'price' => $transactionDetail['harga'],
                    'subtotal' => $transactionDetail['total']
                ];
                $add_detail = $this->Model_transaksi_detail->save($payload_transaction_detail);

                if($add_detail){
                    $isDone = true;
                }else{
                    $isDone = false;
                }
            }
        }

        if ($isDone) {
            $response = [
                'success' => true
            ];
        } else {
            $response = [
                'success' => false
            ];
        }
        return $this->response->setJSON($response);
    }
    
    // edit =================================================================================================
    public function edit_transaksi(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'id_pasien', 'transaction_date', 'total_amount'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $insertData = $this->Model_transaksi->save($data);
        
        if ($insertData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // edit jumlah item ================================================================================
    public function edit_transaksi_detail_jumlah_item(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'quantity', 'subtotal'
            ])
        );
        $data['id'] = $this->request->getPost('id_edit');
        $data['created_by'] = sess_activeUserId();

        $updateData = $this->Model_transaksi_detail->save($data);
        
        if ($updateData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // delete ===============================================================================================
    public function delete_transaksi()
    {
        $deleteData = $this->Model_transaksi->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // delete ===============================================================================================
    public function delete_transaksi_detail()
    {
        $deleteData = $this->Model_transaksi_detail->delete($this->request->getPost('id_delete'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // add payment ==========================================================================================
    public function add_payment(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'id_transaksi', 'nominal_awal', 'diskon_basic', 'diskon_tambahan',
                'nominal_akhir', 'nominal_bayar', 'nominal_kembalian', 'id_payment_method'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $insertData = $this->Model_transaksi_payment->save($data);

        if ($insertData){
            $data['payment_status'] = 'Dibayar';
            $data['id'] = $this->request->getPost('id_transaksi');
            $data['created_by'] = sess_activeUserId();
    
            $updateTransaksi = $this->Model_transaksi->save($data);
        }
        
        if ($insertData && $updateTransaksi) {
            $response = [
                'success' => true,
                'message' => 'Berhasil Bayar.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Gagal Bayar.'
            ];
        }
        return $this->response->setJSON($response);
    }

    // ajax get list transaksi
    public function ajax_get_list_transaksi(){
        $returnedData = $this->Model_transaksi->get_datatable_main();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $invoice = generate_general_code('INV', $baris->id, 6);

            $aksi = "
                <a class='btn btn-sm btn-info' id='btn_edit'
                    data-id='$baris->id'
                >
                    <i class='far fa-edit'></i>
                </a>
                <a class='btn btn-sm btn-danger' id='btn_delete' 
                    data-id='$baris->id'
                    data-invoice='$invoice'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $detail = '
                <a id="btn_show_detail" href="transaksi-show-detail/'.$baris->id.'"
                    class="btn btn-sm btn-info"
                >
                    Detail
                </a>
            ';

            $kode_registrasi = $baris->kode_registrasi=='' ? '-' : $baris->kode_registrasi;

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $invoice . '</span>',
                '<span class="text-center">' . $kode_registrasi . '</span>',
                '<span class="text-center">' . $baris->nama_pasien . '</span>',
                '<span class="text-center">' . $baris->transaction_date . '</span>',
                '<span class="text-center">' . $baris->payment_status . '</span>',
                '<span class="text-center">' . $detail . '</span>',
                '<span class="text-center">' . $aksi . '</span>'
            ];
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $returnedData['count_filtered'],
            "recordsFiltered" => $returnedData['count_all'],
            "data" => $data,
        ];

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    // ajax get list transaksi detail
    public function ajax_get_transaksi_detail($id_transaksi, $payment_status){
        $returnedData = $this->Model_transaksi_detail->get_datatable_registrasi_detail($id_transaksi);

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $aksi = "
                <a class='action-icon text-info' id='btn_edit'
                    data-id='$baris->id'
                    data-quantity='$baris->quantity'
                    data-nama='$baris->nama_item'
                    data-price='$baris->price'
                >
                    <i class='far fa-edit'></i>
                </a>
                <a class='action-icon text-danger' id='btn_delete' 
                    data-id='$baris->id'
                    data-nama='$baris->nama_item'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $tableData = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->nama_item . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->price) . '</span>',
                '<span class="text-center">' . thousand_separator($baris->quantity) . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->subtotal) . '</span>',
            ];

            if ($payment_status == 'Belum Bayar') {
                $tableData[] = '<span class="text-center">' . $aksi . '</span>';
            }

            $data[] = $tableData;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $returnedData['count_filtered'],
            "recordsFiltered" => $returnedData['count_all'],
            "data" => $data,
        ];

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    // ajax get sub total
    public function ajax_get_sub_total(){
        $id_transaksi = $this->request->getPost('id_transaksi');

        $fetch_data = $this->Model_transaksi_detail->get_subtotal_by_id_transaksi($id_transaksi);

        return $this->response->setJSON(['subtotal' => $fetch_data]);
    }

    // cetak struk

    public function cetakstruk ()
    {
        $connector = new NetworkPrintConnector("192.168.0.99", 9100);
        $printer = new Printer($connector);
        
            try {
                // ... Print stuff
                $printer->text('Indra Ganteng');
                $printer->feed(4);
                $printer->cut();
            } finally {
                $printer -> close();
            }
    }

    // test printer
    public function printReceipt()
    {
        // Specify the IP address and port of the Wi-Fi printer
        $printerAddress = '192.168.0.99'; // Example IP address
        $printerPort = 9100; // Default port for most printers

        // Create a printer connector
        $connector = new \Mike42\Escpos\PrintConnectors\NetworkPrintConnector($printerAddress, $printerPort);

        try {
            // Create a printer object
            $printer = new \Mike42\Escpos\Printer($connector);

            // Write printing commands
            $printer->text("Hello, world!\n");
            $printer->cut();

            // Close the printer
            $printer->close();

            // Print successful message
            echo "Receipt printed successfully!";
        } catch (\Exception $e) {
            // Handle any errors that occur during printing
            echo "Error: " . $e->getMessage();
        }
    }


    

}
