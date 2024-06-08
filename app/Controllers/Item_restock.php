<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item_restock;

class Item_restock extends Controller
{
    protected $Model_item_restock;
 
    function __construct(){
        $this->Model_item_restock = new Model_item_restock();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Item Restock']),
			'page_title' => view('partials/page-title', ['title' => 'Inventory', 'pagetitle' => 'Data Item Restock'])
		];
        return view('inventory/page_item_restock', $data);
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
    public function ajax_get_list_main(){
        $returnedData = $this->Model_item_restock->get_datatable_main();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $aksi = "
                <a class='btn btn-sm btn-danger' id='btn_delete' 
                    data-id='$baris->id'
                    data-code='$baris->code'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->code . '</span>',
                '<span class="text-center">' . $baris->type . '</span>',
                '<span class="text-center">' . $baris->item_name .' ('.$baris->item_code.')'. '</span>',
                '<span class="text-center">' . $baris->quantity . '</span>',
                '<span class="text-center">' . $baris->unit . '</span>',
                '<span class="text-center">' . $baris->price . '</span>',
                '<span class="text-center">' . $baris->restock_date . '</span>',
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
