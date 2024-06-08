<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_payment_method;

class Payment_method extends Controller
{
    protected $Model_payment_method;
 
    function __construct(){
        $this->Model_payment_method = new Model_payment_method();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Metode Bayar']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Metode Bayar'])
		];
        return view('data_master/payment_method/page_list_payment_method', $data);
    }
	
    // add ==================================================================================================
    public function add(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'name', 'detail'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $insertDataId = $this->Model_payment_method->insertWithReturnId($data);

        if ($insertDataId){
            $data_update = [
                'kode' => generate_general_code('PM', $insertDataId, 3)
            ];
            $updateResult = $this->Model_payment_method->update($insertDataId, $data_update);

            if($updateResult){
                $response = ['success' => true];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'failed to update kode'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'ok'
            ];
        }

        return json_encode($response);
    }
    
    // edit =================================================================================================
    public function edit(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'name', 'detail'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $updateData = $this->Model_payment_method->save($data);
        
        if ($updateData) {
            $response = ['success' => true];
        } else {
            $response = [
                'success' => false,
                'message' => 'failed to insert'
            ];
        }
        return json_encode($response);
    }
    
    // delete ===============================================================================================
    public function delete()
    {
        $deleteData = $this->Model_payment_method->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return json_encode($response);
    }

    // ajax get list item
    public function ajax_get_list_payment_method(){
        $returnedData = $this->Model_payment_method->get_datatable_main();

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
                    data-kode='$baris->kode'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->kode . '</span>',
                '<span class="text-center">' . $baris->name . '</span>',
                '<span class="text-center">' . $baris->detail . '</span>',
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

}
