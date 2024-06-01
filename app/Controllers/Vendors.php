<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_vendors;
use App\Models\Model_kota;

class Vendors extends Controller
{
    protected $model_vendors, $Model_kota;
 
    function __construct(){
        $this->model_vendors = new Model_vendors();
        $this->Model_kota = new Model_kota();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Vendor']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Vendor']),
            'list_kota' => $this->Model_kota->findAll()
		];
        return view('data_master/vendors/page_list_vendors', $data);
    }
	
    // add ==================================================================================================
    public function add()
    {
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'kode', 'nama', 'tipe', 'alamat', 'id_kota', 'email', 'phone_1', 'phone_2'            
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $save_data = $this->model_vendors->save($data);

        if ($save_data) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // edit =================================================================================================
    public function edit()
    {
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'kode', 'nama', 'tipe', 'alamat', 'id_kota', 'email', 'phone_1', 'phone_2'            
            ])
        );
        $data['id'] = $this->request->getPost('id_edit');
        $data['created_by'] = sess_activeUserId();
        $save_data = $this->model_vendors->save($data);

        if ($save_data) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // delete ===============================================================================================
    public function delete()
    {
        $deleteData = $this->model_vendors->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // ajax get list vendor
    public function ajax_get_list_vendor(){
        $returnedData = $this->model_vendors->get_datatable_main();

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
                        '<span class="text-center">' . $baris->kode . '</span>',
                        '<span class="text-center">' . $baris->nama . '</span>',
                        '<span class="text-center">' . $baris->tipe . '</span>',
                        '<span class="text-center">' . $baris->alamat . '</span>',
                        '<span class="text-center">' . $baris->nama_kota . '</span>',
                        '<span class="text-center">' . $baris->email . '</span>',
                        '<span class="text-center">' . $baris->phone_1 . '</span>',
                        '<span class="text-center">' . $baris->phone_2 . '</span>',
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
    public function ajax_get_vendor_data(){
        $id = $this->request->getPost('id_vendor');

        $fetch_edit_data = $this->model_vendors->get_by_id($id);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
