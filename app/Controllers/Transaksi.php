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
use App\Models\Model_medical_record;
use App\Models\Model_medical_record_detail;
use App\Models\Model_item;
use App\Models\Model_item_detail;
use App\Models\Model_payment_method;
use App\Models\Model_distribution_channel;

class Transaksi extends Controller
{
    protected $Model_transaksi, $Model_kategori, $Model_pasien, $Model_transaksi_detail, $Model_transaksi_payment,
        $Model_item_transaksi_stock, $Model_medical_record, $Model_medical_record_detail, $Model_item,
        $Model_payment_method, $Model_distribution_channel, $Model_item_detail;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_kategori = new Model_kategori();
        $this->Model_pasien = new Model_pasien();
        $this->Model_transaksi_detail = new Model_transaksi_detail();
        $this->Model_transaksi_payment = new Model_transaksi_payment();
        $this->Model_item_transaksi_stock = new Model_item_transaksi_stock();
        $this->Model_medical_record = new Model_medical_record();
        $this->Model_medical_record_detail = new Model_medical_record_detail();
        $this->Model_item = new Model_item();
        $this->Model_payment_method = new Model_payment_method();
        $this->Model_distribution_channel = new Model_distribution_channel();
        $this->Model_item_detail = new Model_item_detail();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Kasir']),
			'page_title' => view('partials/page-title', ['title' => 'POS', 'pagetitle' => 'Kasir']),
            'data_payment_method' => $this->Model_payment_method->findAll(),
            'data_payment_status' => $this->Model_kategori->get_payment_status(),
            'data_registration_status' => $this->Model_kategori->get_registration_status(),
            'data_pasien' => $this->Model_pasien->findAll(),
            'items' => $this->Model_item->get_all_array(),
            'data_distribution_channel' => $this->Model_distribution_channel->findAll()
		];
        return view('kasir/page_kasir_2', $data);
    }

    public function show_kasir_new(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Kasir']),
			'page_title' => view('partials/page-title', ['title' => 'POS', 'pagetitle' => 'Kasir']),
            'data_payment_method' => $this->Model_payment_method->findAll(),
            'data_payment_status' => $this->Model_kategori->get_payment_status(),
            'data_registration_status' => $this->Model_kategori->get_registration_status(),
            'data_pasien' => $this->Model_pasien->findAll(),
            'items' => $this->Model_item->get_all_array(),
            'data_distribution_channel' => $this->Model_distribution_channel->findAll()
		];
        return view('kasir/page_kasir_2', $data);
    }

    // show list transaksi
    public function show_list_transaksi(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Transaksi']),
			'page_title' => view('partials/page-title', ['title' => 'Kasir', 'pagetitle' => 'List Transaksi']),
            'data_payment_method' => $this->Model_kategori->get_payment_method(),
            'data_payment_status' => $this->Model_kategori->get_payment_status(),
            'data_registration_status' => $this->Model_kategori->get_registration_status(),
            'data_pasien' => $this->Model_pasien->findAll(),
            'items' => $this->Model_item->get_all_array()
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
    public function add_transaksi($param=[]){
        $currDateTime = date('Y-m-d H:i:s');
        // insert transaction
        $data = [
            'transaction_date' => $currDateTime,
            'payment_status' => 'Dibayar',
            'id_distribution_channel' => $this->request->getPost('id_distribution_channel'),
            'id_payment_method' => $this->request->getPost('id_payment_method'),
            'created_by' => sess_activeUserId(),
            'id_entitas' => 1
        ];
        $insertDataId = $this->Model_transaksi->insertWithReturnId($data);

        if ($insertDataId) {
            // inject invoice code
            $data_trans_update = [
                'no_invoice' => generate_general_code('INV', $insertDataId, 9)
            ];
            $updateResult = $this->Model_transaksi->update($insertDataId, $data_trans_update);

            $transactionDetailData = $this->request->getPost('transaction_detail');
            // $transactionDetails = json_decode($transactionDetailData, true);

            if (!empty($transactionDetailData) && is_array($transactionDetailData)) {
                foreach ($transactionDetailData as $transactionDetail) {
                    // insert transaksi detail
                    $payload_transaction_detail = [
                        'id_transaksi' =>  $insertDataId,
                        'id_item' => $transactionDetail['id_item'],
                        'quantity' => $transactionDetail['jumlah'],
                        'unit' => $transactionDetail['unit'],
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
                        'tanggal_kegiatan' => $currDateTime,
                        'id_entitas' => 1,
                        'created_by' => sess_activeUserId()
                    ];
                    $this->Model_item_transaksi_stock->addTransaksiStock($payload_add_transaksi_stock);

                    // if has formula
                    if($transactionDetail['is_has_formula'] == 1){
                        // get formula
                        $get_formula = $this->Model_item_detail->get_by_id_main_item($transactionDetail['id_item']);

                        // loop through it
                        foreach($get_formula as $formula_list){
                            // insert transaksi stock
                            $payload_add_transaksi_stock_formula = [
                                'id_item' => $formula_list['id_item'],
                                'jumlah' => -$formula_list['jumlah'] * $transactionDetail['jumlah'], 
                                'jenis' => 'keluar', 
                                'kegiatan' => 'otomasi formula dari penjualan kasir', 
                                'id_kegiatan' => $insertDataId, 
                                'tanggal_kegiatan' => $currDateTime,
                                'id_entitas' => 1,
                                'created_by' => sess_activeUserId()
                            ];
                            $this->Model_item_transaksi_stock->addTransaksiStock($payload_add_transaksi_stock_formula);
                        }
                    }

                }
            }

            // payment
            $dataPayment = array_intersect_key(
                $this->request->getPost(),
                array_flip([
                    'nominal_awal', 'diskon_tambahan', 'id_payment_method',
                    'nominal_akhir', 'nominal_bayar', 'nominal_kembalian'
                ])
            );
            $dataPayment['id_transaksi'] = $insertDataId;
            $dataPayment['created_by'] = sess_activeUserId();
            $insertPayment = $this->Model_transaksi_payment->save($dataPayment);
            
            if ($updateResult && $insertPayment) {
                $printData = [
                    'dataTransaksi' => $this->Model_transaksi->get_by_id($insertDataId),
                    'detailTransaksi' => $this->Model_transaksi_detail->get_by_id_transaksi($insertDataId),
                    'detailBayar' => $this->Model_transaksi_payment->get_by_id_transaksi($insertDataId)
                ];
                $response = [
                    'success' => true,
                    'printData' => $printData
                ];
            } else {
                $response = [
                    'success' => false
                ];
            }
            
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
        $idTransaksi = $this->request->getPost('id_transaksi');
        $isFromRegistration = $this->request->getPost('is_from_registration');

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
            $data['id'] = $idTransaksi;
            $data['created_by'] = sess_activeUserId();
    
            $updateTransaksi = $this->Model_transaksi->save($data);
        }

        if($updateTransaksi && $isFromRegistration==0){
            $notes = "Medical Record dari transaksi kasir";

            // get updated regist data
            $data_transaction = $this->Model_transaksi->get_by_id($idTransaksi);

            // create mr
            $data_create_mr = [
                'id_transaction' => $data_transaction[0]->id,
                'id_patient' => $data_transaction[0]->id_pasien,
                'id_entitas' => $data_transaction[0]->id_entitas,
                'notes' => $notes,
                'record_date' => dbDate($data_transaction[0]->transaction_date)
            ];
            $data_create_mr['created_by'] = sess_activeUserId();
            $insertedMrId = $this->Model_medical_record->insertWithReturnId($data_create_mr);

            // get trans detail
            $transactionDetailData = $this->Model_transaksi_detail->get_by_id_transaksi($data_transaction[0]->id);

            if (!empty($transactionDetailData) && is_array($transactionDetailData)) {
                foreach ($transactionDetailData as $transactionDetail) {
                    // Insert mr detail
                    $payload_mr_detail = [
                        'id_mr' =>  $insertedMrId,
                        'id_item' => $transactionDetail->id_item,
                        'item_quantity' => $transactionDetail->quantity
                    ];
        
                    // Attempt to save transaction detail
                    $saveResult = $this->Model_medical_record_detail->save($payload_mr_detail);
        
                    // Check if save was successful
                    if (!$saveResult) {
                        error_log('Error saving mr detail: ' . $this->Model_medical_record_detail->errors());
                    }
                }
            }
        }
        
        if ($insertData && $updateTransaksi && $saveResult) {
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
            $aksi = "
                <a class='btn btn-sm btn-info' id='btn_edit'
                    data-id='$baris->id'
                >
                    <i class='far fa-edit'></i>
                </a>
                <a class='btn btn-sm btn-danger' id='btn_delete' 
                    data-id='$baris->id'
                    data-invoice='$baris->no_invoice'
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

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->no_invoice . '</span>',
                '<span class="text-center">' . $baris->transaction_date . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->total_nominal, 2) . '</span>',
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

    // ajax get data edit
    public function ajax_get_item_data(){
        $edit_id = $this->request->getPost('edit_id');

        $fetch_edit_data = $this->Model_transaksi->get_by_id($edit_id);

        return $this->response->setJSON($fetch_edit_data[0]);
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
        try {
            // IP address and port of the printer
            $printer_ip = '192.168.0.99';
            $printer_port = 9100;

            // Create a socket to connect to the printer
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if ($socket === false) {
                echo "Failed to create socket: " . socket_strerror(socket_last_error()) . "\n";
                exit(1);
            }

            // Connect to the printer
            $result = socket_connect($socket, $printer_ip, $printer_port);
            if ($result === false) {
                echo "Failed to connect to printer: " . socket_strerror(socket_last_error()) . "\n";
                exit(1);
            }

            // Print data to send to the printer
            $print_data = "This is a test print from PHP.";

            // Send print data to the printer
            $result = socket_write($socket, $print_data, strlen($print_data));
            if ($result === false) {
                echo "Failed to send print data to printer: " . socket_strerror(socket_last_error()) . "\n";
            } else {
                echo "Print data sent successfully.\n";
            }

            // Close the socket connection
            socket_close($socket);

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    // test printer
    public function printReceipt($id_transaksi)
    {
        $data = [
            'dataTransaksi' => $this->Model_transaksi->get_by_id($id_transaksi),
            'detailTransaksi' => $this->Model_transaksi_detail->get_by_id_transaksi($id_transaksi),
            'detailBayar' => $this->Model_transaksi_payment->get_by_id_transaksi($id_transaksi),
            'invoice' => generate_general_code('INV', $id_transaksi, 6)
        ];
        return view('kasir/page_print', $data);
    }


    


    

}

    