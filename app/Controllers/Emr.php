<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_medical_record;
use App\Models\Model_medical_record_detail;
use App\Models\Model_transaksi;
use App\Models\Model_kategori;
use App\Models\Model_pasien;
use App\Models\Model_transaksi_detail;

class Emr extends Controller
{
    protected $Model_transaksi, $Model_kategori, $Model_pasien, $Model_transaksi_detail, $Model_medical_record, 
        $Model_medical_record_detail;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_kategori = new Model_kategori();
        $this->Model_pasien = new Model_pasien();
        $this->Model_transaksi_detail = new Model_transaksi_detail();
        $this->Model_medical_record = new Model_medical_record();
        $this->Model_medical_record_detail = new Model_medical_record_detail();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Electronic Medical Record']),
			'page_title' => view('partials/page-title', ['title' => 'EMR', 'pagetitle' => 'List EMR'])
		];
        return view('MR/page_list_mr', $data);
    }

    // show medical record
    public function show_medical_record(){
        $filteredData = $this->Model_medical_record->get_by_id_patient();

        $groupedRecords = [];

        foreach ($filteredData as $record) {
            $recordId = $record['id'];
            
            if (!isset($groupedRecords[$recordId])) {
                $groupedRecords[$recordId] = [
                    'record_id' => $record['id'],
                    'id_patient' => $record['id_patient'],
                    'record_date' => indoDate($record['record_date']),
                    'patient_name' => $record['patient_name'],
                    'patient_code' => $record['patient_code'],
                    'notes' => $record['notes'],
                    'items' => []
                ];
            }
            
            $groupedRecords[$recordId]['items'][] = [
                'item_id' => $record['item_id'],
                'item_quantity' => $record['item_quantity'],
                'item_name' => $record['item_name'],
                'item_satuan' => $record['item_satuan']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => array_reverse(array_values($groupedRecords))
        ]);
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
                    $payload_transaction_detail = [
                        'id_transaksi' =>  $insertDataId,
                        'id_item' => $transactionDetail['id_item'],
                        'quantity' => $transactionDetail['jumlah'],
                        'price' => $transactionDetail['harga'],
                        'subtotal' => $transactionDetail['total']
                    ];
                    $this->Model_transaksi_detail->save($payload_transaction_detail);
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
    public function ajax_get_transaksi_detail($id_transaksi){
        $returnedData = $this->Model_transaksi_detail->get_datatable_registrasi_detail($id_transaksi);

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->nama_item . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->price) . '</span>',
                '<span class="text-center">' . thousand_separator($baris->quantity) . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->subtotal) . '</span>'
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

    // ajax get sub total
    public function ajax_get_sub_total(){
        $id_transaksi = $this->request->getPost('id_transaksi');

        $fetch_data = $this->Model_transaksi_detail->get_subtotal_by_id_transaksi($id_transaksi);

        return $this->response->setJSON(['subtotal' => $fetch_data]);
    }

}
