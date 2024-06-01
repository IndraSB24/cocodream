<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_brand;

class Brand extends Controller
{
    protected $model_brand;
 
    function __construct(){
        $this->model_brand = new Model_brand();
        helper(['session_helper']);
        helper(['formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Brand']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Brand'])
		];
        return view('data_master/brand/page_list_brand', $data);
    }

    // Show =================================================================================================
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
	
    // add ==================================================================================================
    public function add($kode = null)
    {
        switch ($kode) {
            case 'brand':
                $data = [
                    'kode' => $this->request->getPost('kode'), 
                    'nama' => $this->request->getPost('nama'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'created_by' => sess_activeUserId()
                ];
                
                $insertData = $this->model_brand->save($data);
                
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
    
    // edit =================================================================================================
    public function edit($kode = null)
    {
        switch ($kode) {
            case 'brand':
                $data = [
                    'id'        => $this->request->getPost('edit_id'),
                    'kode'      => $this->request->getPost('kode_edit'),
                    'nama'      => $this->request->getPost('nama_edit'),
                    'deskripsi' => $this->request->getPost('deskripsi_edit')
                ];
                $insertData = $this->model_brand->save($data);
                
                if ($insertData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }
    
    // delete ===============================================================================================
    public function delete($kode = null)
    {
        switch ($kode) {
            case 'data_brand':
                $deleteData = $this->model_brand->delete($this->request->getPost('id'));

                if ($deleteData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }

    // ajax get =============================================================================================
    public function ajax_get($kode="")
    {
        switch ($kode) {
            case 'list_brand':
                $returnedData = $this->model_brand->getDatatables();

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
                            data-nama='$baris->nama'
                        > 
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    ";

                    $data[] = [
                        '<span class="text-center">' . $itung+1 . '</span>',
                        '<span class="text-center">' . $baris->kode . '</span>',
                        '<span class="text-center">' . $baris->nama . '</span>',
                        '<span class="text-center">' . $baris->deskripsi . '</span>',
                        '<span class="text-center">' . $aksi . '</span>'
                    ];
                }

                $output = [
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model_brand->countNoFiltered(),
                    "recordsFiltered" => $this->model_brand->countFiltered(),
                    "data" => $data,
                ];

                // Output to JSON format
                return $this->response->setJSON($output);
            break;

            case 'edit_data':
                $edit_id = $this->request->getPost('edit_id');

                $fetch_edit_data = $this->model_brand->get_by_id($edit_id);

                return $this->response->setJSON($fetch_edit_data[0]);
            break;

            default:
                return $this->response->setJSON(array());
        }
    }

    // ajax get data edit
    public function ajax_get_brand_data(){
        $id_brand = $this->request->getPost('id_brand');

        $fetch_edit_data = $this->model_brand->get_by_id($id_brand);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
