<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_kategori;

class Kategori extends Controller
{
    protected $Model_kategori;
 
    function __construct(){
        $this->Model_kategori = new Model_kategori();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Kategori']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Kategori'])
		];
        return view('data_master/satuan/page_list_satuan', $data);
    }

    // show jenis item
    public function show_jenis_item()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Jenis Item']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Jenis Item'])
		];
        return view('data_master/jenis_item/page_list_jenis_item', $data);
    }

    // show kategori item
    public function show_kategori_item()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Kategori Item']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Kategori Item'])
		];
        return view('data_master/kategori_item/page_list_kategori_item', $data);
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
            case 'satuan':
                $data = [
                    'kode' => $this->request->getPost('kode'), 
                    'nama' => $this->request->getPost('nama'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'created_by' => sess_activeUserId()
                ];
                
                $insertData = $this->model_satuan->save($data);
                
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
            case 'satuan':
                $data = [
                    'id'        => $this->request->getPost('edit_id'),
                    'kode'      => $this->request->getPost('kode_edit'),
                    'nama'      => $this->request->getPost('nama_edit'),
                    'deskripsi' => $this->request->getPost('deskripsi_edit')
                ];
                $insertData = $this->model_satuan->save($data);
                
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
            case 'data_satuan':
                $deleteData = $this->model_satuan->delete($this->request->getPost('id'));

                if ($deleteData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }

    // ajax get list jenis item
    public function ajax_get_by_tipe($tipe){
        $returnedData = $this->Model_kategori->get_datatable_main($tipe);

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
                '<span class="text-center">' . $baris->nama . '</span>',
                '<span class="text-center">' . $baris->deskripsi . '</span>',
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
    public function ajax_get_kategori_data(){
        $id = $this->request->getPost('id_to_get');

        $fetch_edit_data = $this->Model_kategori->get_by_id($id);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
