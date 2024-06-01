<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item;
use App\Models\Model_item_detail;

class Item_detail extends Controller
{
    protected $Model_item, $Model_item_detail;
 
    function __construct(){
        $this->Model_item_detail = new Model_item_detail();
        $this->Model_item = new Model_item();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index($id_item_utama)
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Item']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Item']),
            'data_item' => $this->Model_item->get_all(),
            'id_item_utama' => $id_item_utama
		];
        return view('data_master/item/page_item_detail', $data);
    }

    // add ==================================================================================================
    public function add_item_detail(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'id_item_utama', 'id_item', 'jumlah'
            ])
        );
        $data['created_by'] = sess_activeUserId();

        $insertData = $this->Model_item_detail->save($data);
        
        if ($insertData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // edit =================================================================================================
    public function edit_item(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'jumlah'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $insertData = $this->Model_item_detail->save($data);
        
        if ($insertData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // delete ===============================================================================================
    public function delete_item()
    {
        $deleteData = $this->Model_item_detail->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // ajax get list item
    public function ajax_get_list_item($id_item_utama){
        $returnedData = $this->Model_item_detail->get_datatable_main($id_item_utama);

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
                    data-nama='$baris->nama_item'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->kode_item . '</span>',
                '<span class="text-center">' . $baris->nama_item . '</span>',
                '<span class="text-center">' . $baris->jumlah . '</span>',
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
    public function ajax_get_item_data(){
        $edit_id = $this->request->getPost('edit_id');

        $fetch_edit_data = $this->Model_item_detail->get_by_id($edit_id);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
