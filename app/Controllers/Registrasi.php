<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_registrasi;
use App\Models\Model_pasien;
use App\Models\Model_karyawan;
use App\Models\Model_entitas_usaha;
use App\Models\Model_transaksi_detail;
use App\Models\Model_transaksi;
use App\Models\Model_registrasi_detail;
use App\Models\Model_medical_record;
use App\Models\Model_medical_record_detail;
use App\Models\Model_karyawan_jabatan;

class Registrasi extends Controller
{
    protected $model_registrasi, $model_pasien, $model_karyawan, $model_entita, $Model_transaksi_detail,
        $Model_transaksi, $Model_registrasi_detail, $Model_medical_record, $Model_medical_record_detail,
        $Model_karyawan_jabatan;
 
    function __construct(){
        $this->model_registrasi = new Model_registrasi();
        $this->model_pasien = new Model_pasien();
        $this->model_karyawan = new Model_karyawan();
        $this->model_entitas_usaha = new Model_entitas_usaha();
        $this->Model_transaksi_detail = new Model_transaksi_detail();
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_registrasi_detail = new Model_registrasi_detail();
        $this->Model_medical_record = new Model_medical_record();
        $this->Model_medical_record_detail = new Model_medical_record_detail();
        $this->Model_karyawan_jabatan = new Model_karyawan_jabatan();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Registrasi']),
			'page_title' => view('partials/page-title', ['title' => 'Registrasi', 'pagetitle' => '']),
            'list_pasien'=> $this->model_pasien->findAll(),
            'list_entitas' => $this->model_entitas_usaha->findAll(),
            'data_staff' => $this->Model_karyawan_jabatan->get_nakes(sess_activeEntitasId())
		];
        return view('registrasi/page_list_registrasi', $data);
    }

    public function show_registrasi_detail($id){
        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Registrasi Detail']),
            'page_title' => view('partials/page-title', ['title' => 'Registrasi', 'pagetitle' => 'Detail']),
            'id_detail' => $id,
            'data_registrasi' => $this->model_registrasi->get_by_id($id),
            'data_staff' => $this->Model_karyawan_jabatan->get_nakes(sess_activeEntitasId())
        ];
        return view('registrasi/page_registrasi_detail', $data);
    }
	
    // add ================================================================================
    public function add($kode = null)
    {
        switch ($kode) {
            case 'registrasi':
                $data = [
                    'id_entitas' => $this->request->getPost('entitas'), 
                    'id_pasien' => $this->request->getPost('pasien'),
                    'id_staff' => $this->request->getPost('staff'),
                    'plan_date' => $this->request->getPost('plan_date'),
                    'created_by' => sess_activeUserId()
                ];
                
                $insertData = $this->model_registrasi->save($data);
                
                if ($insertData) {
                    $response = [
                        'success' => true,
                        'message' => 'success'
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'success'
                    ];
                }
                return $this->response->setJSON($response);
            break;
        }
    }

    // add resgitrasi ======================================================================
    public function add_registrasi(){
        // insert transaction
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'id_entitas', 'id_pasien', 'id_staff', 'plan_date'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $insertDataId = $this->model_registrasi->insertWithReturnId($data);

        if ($insertDataId) {
            // inject registration code
            $data_regist_update = [
                'kode' => generate_general_code('CL-REG', $insertDataId, 6)
            ];
            $updateResult = $this->model_registrasi->update($insertDataId, $data_regist_update);
        

            // get transaction detail payload
            $transactionDetailData = $this->request->getPost('transaction_detail');
        
            if (!empty($transactionDetailData) && is_array($transactionDetailData)) {
                foreach ($transactionDetailData as $transactionDetail) {
                    // Insert transaction detail
                    $payload_registration_detail = [
                        'id_registration' =>  $insertDataId,
                        'id_item' => $transactionDetail['id_item'],
                        'quantity' => $transactionDetail['jumlah'],
                        'price' => $transactionDetail['harga'],
                        'subtotal' => $transactionDetail['total'],
                        'id_entitas' => $this->request->getPost('id_entitas')
                    ];
        
                    // Attempt to save transaction detail
                    $saveResult = $this->Model_registrasi_detail->save($payload_registration_detail);
        
                    // Check if save was successful
                    if (!$saveResult) {
                        // Handle error - log, notify, etc.
                        // Example: Log the error message
                        error_log('Error saving transaction detail: ' . $this->Model_registrasi_detail->errors());
                    }
                }
            }
        
            // Check if any errors occurred during transaction detail insertion
            if ($this->Model_registrasi_detail->errors()) {
                // Handle overall error - rollback, notify user, etc.
                $response = [
                    'success' => false,
                    'error' => 'An error occurred while saving transaction details. Please try again later.'
                    // You can provide more specific error messages based on the type of error
                ];
            } else {
                // No errors occurred
                $response = [
                    'success' => true
                ];
            }
        } else {
            // Handle error if $insertDataId is false or null
            $response = [
                'success' => false,
                'error' => 'Failed to insert main transaction data.'
                // You can provide more specific error messages based on the reason for failure
            ];
        }
        return $this->response->setJSON($response);
    }

    // add registrasi detail ===============================================================
    public function add_registrasi_detail(){
        $itemDetail = $this->request->getPost('item_detail');
        $id_registration = $this->request->getPost('id_registration');
        $id_entitas = $this->request->getPost('id_entitas');
        
        if (!empty($itemDetail) && is_array($itemDetail)) {
            foreach ($itemDetail as $listItemDetail) {
                $payload_registration_detail = [
                    'id_registration' =>  $id_registration,
                    'id_item' => $listItemDetail['id_item'],
                    'quantity' => $listItemDetail['jumlah'],
                    'price' => $listItemDetail['harga'],
                    'subtotal' => $listItemDetail['total'],
                    'id_entitas' => $id_entitas
                ];
                $add_detail = $this->Model_registrasi_detail->save($payload_registration_detail);

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

    // waiting status
    public function waiting_status(){
        $idRegistrasi = $this->request->getPost('id_registrasi');

        $data = [
            'id' => $idRegistrasi,
            'status' => "waiting",
            'created_by' => sess_activeUserId(),
            'actual_date' => date('Y-m-d H:i:s')
        ];
        $updateData = $this->model_registrasi->save($data);

        if($updateData){
            // get updated regist data
            $data_registration = $this->model_registrasi->get_by_id($idRegistrasi);

            // create transaction
            $data_create_transaction = [
                'id_registration' => $data_registration[0]->id,
                'id_pasien' => $data_registration[0]->id_pasien,
                'transaction_date' => date("Y-m-d H:i:s"),
                'is_from_registration' => 1
            ];
            $data_create_transaction['created_by'] = sess_activeUserId();
            $insertTransId = $this->Model_transaksi->insertWithReturnId($data_create_transaction);

            // update invoice
            if($insertTransId){
                // inject invoice code
                $data_trans_update = [
                    'no_invoice' => generate_general_code('INV', $insertTransId, 6)
                ];
                $updateResult = $this->Model_transaksi->update($insertTransId, $data_trans_update);
            }

            // get registration detail
            $transactionDetailData = $this->Model_registrasi_detail->get_by_id_registrasi($idRegistrasi);

            if (!empty($transactionDetailData) && is_array($transactionDetailData)) {
                foreach ($transactionDetailData as $transactionDetail) {
                    // Insert transaction detail
                    $payload_transaction_detail = [
                        'id_transaksi' =>  $insertTransId,
                        'id_item' => $transactionDetail->id_item,
                        'quantity' => $transactionDetail->quantity,
                        'price' => $transactionDetail->price,
                        'subtotal' => $transactionDetail->subtotal,
                        'id_entitas' => $transactionDetail->id_entitas
                    ];
        
                    // Attempt to save transaction detail
                    $saveResult = $this->Model_transaksi_detail->save($payload_transaction_detail);
        
                    // Check if save was successful
                    if (!$saveResult) {
                        error_log('Error saving transaction detail: ' . $this->Model_registrasi_detail->errors());
                    }
                }
            }
        
            // Check if any errors occurred during transaction detail insertion
            if ($this->Model_transaksi_detail->errors()) {
                // Handle overall error - rollback, notify user, etc.
                $response = [
                    'success' => false,
                    'error' => 'An error occurred while saving transaction details. Please try again later.'
                    // You can provide more specific error messages based on the type of error
                ];
            } else {
                // No errors occurred
                $response = [
                    'success' => true
                ];
            }
        }else{
            $response = [
                'success' => false
            ];
        }
        
        return $this->response->setJSON($response);
    }
 
    // engaged status ======================================================================
    public function on_treatment_status(){
        // insert transaction
        $data = [
            'id' => $this->request->getPost('id_registrasi'),
            'status' => "on treatment",
            'created_by' => sess_activeUserId()
        ];
        
        if($this->request->getPost('id_staff')){
            $data['id_staff'] = $this->request->getPost('id_staff');
        }

        $updateData = $this->model_registrasi->save($data);

        if ($updateData) {
            $response = [
                'success' => true,
                'error' => 'Success to engage.'
            ];
        } else {
            // Handle error if $insertDataId is false or null
            $response = [
                'success' => false,
                'error' => 'Failed to engage.'
            ];
        }
        return $this->response->setJSON($response);
    }

    // waiting status
    public function done_status(){
        $idRegistrasi = $this->request->getPost('id_registrasi');
        $notes = $this->request->getPost('notes');

        $data = [
            'id' => $idRegistrasi,
            'status' => "done",
            'created_by' => sess_activeUserId()
        ];
        $updateData = $this->model_registrasi->save($data);

        if($updateData){
            // get updated regist data
            $data_transaction = $this->Model_transaksi->get_by_id_registrasi($idRegistrasi);

            // create mr
            $data_create_mr = [
                'id_registration' => $data_transaction[0]->id_registration,
                'id_transaction' => $data_transaction[0]->id,
                'id_patient' => $data_transaction[0]->id_pasien,
                'id_entitas' => $data_transaction[0]->id_entitas,
                'notes' => $notes,
                'record_date' => date("Y-m-d")
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
        
            // Check if any errors occurred during transaction detail insertion
            if ($this->Model_medical_record_detail->errors()) {
                // Handle overall error - rollback, notify user, etc.
                $response = [
                    'success' => false,
                    'error' => 'An error occurred while saving mr details. Please try again later.'
                    // You can provide more specific error messages based on the type of error
                ];
            } else {
                // No errors occurred
                $response = [
                    'success' => true
                ];
            }
        }else{
            $response = [
                'success' => false
            ];
        }

        return $this->response->setJSON($response);
    }

    // ajax get list registrasi
    public function ajax_get_list_registrasi(){
        $returnedData = $this->model_registrasi->getDatatables();

        $data = [];
        foreach ($returnedData as $itung => $baris) {
            $aksi = "
                <a class='btn btn-sm btn-info' id='btn_edit'
                    data-id='$baris->id'
                >
                    <i class='far fa-edit'></i>
                </a>
                <a class='btn btn-sm btn-danger' id='btn_delete' 
                    data-id='$baris->id'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $detail = '
                <a href="registrasi-show-detail/'.$baris->id.'"
                    class="btn btn-sm btn-info"
                >
                    Detail
                </a>
            ';

            switch($baris->status){
                case 'scheduled':
                    $status_badge_class = 'btn-warning';
                break;
                case 'waiting':
                    $status_badge_class = 'btn-danger';
                break;
                case 'on treatment':
                    $status_badge_class = 'btn-info';
                break;
                case 'done':
                    $status_badge_class = 'btn-success';
                break;
            }

            $status = '
                <a class="btn btn-sm '.$status_badge_class.'" href="#">'.
                    $baris->status.
                '</a>
            ';

            $data[] = [
                '<span class="text-center">' . $itung+1 . '</span>',
                '<span class="text-center">' . generate_general_code('CL-REG', $baris->id, 6). '</span>',
                '<span class="text-center">' . $baris->nama_entitas. '</span>',
                '<span class="text-center">' . $baris->kode_pasien. '</span>',
                '<span class="text-center">' . $baris->nama_pasien . '</span>',
                '<span class="text-center">' . $baris->nama_staff . '</span>',
                '<span class="text-center">' . $baris->plan_date . '</span>',
                '<span class="text-center">' . $baris->actual_date . '</span>',
                '<span class="text-center">' . $status . '</span>',
                '<span class="text-center">' . $detail . '</span>',
                '<span class="text-center">' . $aksi . '</span>'
            ];
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_registrasi->countNoFiltered(),
            "recordsFiltered" => $this->model_registrasi->countFiltered(),
            "data" => $data,
        ];

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    // ajax get detail registrasi
    public function ajax_get_registrasi_detail($id){
        $returnedData = $this->Model_registrasi_detail->get_datatable_registrasi_detail($id);

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
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . $itung+1 . '</span>',
                '<span class="text-center">' . $baris->kode_item. '</span>',
                '<span class="text-center">' . $baris->nama_item. '</span>',
                '<span class="text-center">' . $baris->quantity . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>',
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
    public function ajax_get_registrasi_data(){
        $edit_id = $this->request->getPost('edit_id');

        $fetch_edit_data = $this->model_registrasi->get_by_id($edit_id);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
