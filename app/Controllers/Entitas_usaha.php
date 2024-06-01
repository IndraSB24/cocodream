<?php

namespace App\Controllers;

use App\Models\Model_entitas_usaha;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_provinsi;
use App\Models\Model_kota;

class Entitas_usaha extends Controller
{
    protected $model_entitas_usaha, $model_provinsi, $model_kota;
 
    function __construct(){
        $this->model_entitas_usaha = new Model_entitas_usaha();
        $this->model_provinsi = new Model_provinsi();
        $this->model_kota = new Model_kota();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Entitas Usaha']),
			'page_title' => view('partials/page-title', ['title' => 'Master Data', 'pagetitle' => 'List Entitas Usaha']),
            'list_provinsi' => $this->model_provinsi->findAll(),
            'list_kota' => $this->model_kota->findAll()
		];
        return view('data_master/entitas_usaha/page_list_entitas_usaha', $data);
    }

    // Show ================================================================================================================================================================	
	public function show(request $param){
        switch($param->kode){
            case 'document_timeline':
                $title = $param;
                $data = [
        			'title_meta' => view('partials/title-meta', ['title' => $param->title.' Timeline']),
        			'page_title' => view('partials/page-title', ['title' => 'Timeline', 'pagetitle' => $param->title]),
        			'passed_data' => $this->doc_engineering_model->find()
        		];
        		return view('timeline-document', $data);
            break;
            case 'actual_ifr_file':
                $data = [
                    'actual_ifr_file'   => $this->request->getPost('file'),
                    'actual_ifr'        => date_now(),
                ];
                $this->doc_engineering_model->update($id_update, $data);
            break;
            case 'actual_ifa_file':
                $data = [
                    'actual_ifa_file'   => $this->request->getPost('file'),
                    'actual_ifa'        => date_now(),
                ];
                $this->doc_engineering_model->update($id_update, $data);
            break;
            case 'actual_ifc_file':
                $data = [
                    'actual_ifc_file'   => $this->request->getPost('file'),
                    'actual_ifc'        => date_now(),
                ];
                $this->doc_engineering_model->update($id_update, $data);
            break;
        }
    }
	
    // add ================================================================================================================================================================
    public function add_entitas_usaha(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'nama', 'id_entitas_tipe', 'id_kota', 'alamat'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        
        $insertData = $this->model_entitas_usaha->save($data);
        
        if ($insertData) {
            $response = [
                'success' => true,
                'message' => 'Entitas Usaha baru berhasil disimpan.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Gagal menyimpan Entitas Usaha.'
            ];
        }
        return $this->response->setJSON($response);
    }
    
    // edit ================================================================================================================================================================
    public function edit_entitas_usaha()
    {
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'nama', 'id_entitas_tipe', 'id_kota', 'alamat'            
            ])
        );
        $data['id'] = $this->request->getPost('id_edit');
        $data['created_by'] = sess_activeUserId();
        $save_data = $this->model_entitas_usaha->save($data);

        if ($save_data) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // delete ==============================================================================================================================================================
    public function delete_entitas_usaha()
    {
        
        $deleteData = $this->model_entitas_usaha->delete($this->request->getPost('id'));

                if ($deleteData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
    }

    // ajax get data edit
    public function ajax_get_entitas_data(){
        $id_entitas = $this->request->getPost('id_entitas');

        $fetch_edit_data = $this->model_entitas_usaha->get_by_id($id_entitas);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

    // ajax get list cashdrawer
    public function ajax_get_list_entitas(){
        $returnedData = $this->model_entitas_usaha->get_datatable_main();

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
                    data-nama='$baris->nama'
                    data-path='".base_url('entitas_usaha/delete/data_entitas_usaha')."'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . ($itung+1) . '</span>',
                '<span class="text-center">' . $baris->nama . '</span>',
                '<span class="text-center">' . $baris->nama_entitas_tipe . '</span>',
                '<span class="text-center">' . $baris->alamat . '</span>',
                '<span class="text-center">' . $baris->nama_kota . '</span>',
                '<span class="text-center">' . $baris->nama_provinsi . '</span>',
                $aksi
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
