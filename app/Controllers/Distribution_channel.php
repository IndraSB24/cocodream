<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_distribution_channel;

class Distribution_channel extends Controller
{
    protected $Model_distribution_channel;
 
    function __construct(){
        $this->Model_distribution_channel = new Model_distribution_channel();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Distribution Channel']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Distribution Channel'])
		];
        return view('data_master/distribution_channel/page_list_distribution_channel', $data);
    }
	
    // add ==================================================================================================
    public function add(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'name', 'description'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $insertDataId = $this->Model_distribution_channel->insertWithReturnId($data);

        if ($insertDataId){
            $data_update = [
                'kode' => generate_general_code('PM', $insertDataId, 3)
            ];
            $updateResult = $this->Model_distribution_channel->update($insertDataId, $data_update);

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
                'message' => 'failed'
            ];
        }

        return json_encode($response);
    }
    
    // edit =================================================================================================
    public function edit(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'name', 'description'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $updateData = $this->Model_distribution_channel->save($data);
        
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
        $deleteData = $this->Model_distribution_channel->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return json_encode($response);
    }

    // ajax get list item
    public function ajax_get_list_payment_method(){
        $returnedData = $this->Model_distribution_channel->get_datatable_main();

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
                '<span class="text-center">' . $baris->description . '</span>',
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
