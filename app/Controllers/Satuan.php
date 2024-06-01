<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_satuan;

class Satuan extends Controller
{
    protected $model_satuan;
 
    function __construct(){
        $this->model_satuan = new Model_satuan();
        helper(['session_helper']);
        helper(['formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Satuan']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Satuan'])
		];
        return view('data_master/satuan/page_list_satuan', $data);
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

    // ajax get =============================================================================================
    public function ajax_get($kode="")
    {
        switch ($kode) {
            case 'list_satuan':
                $returnedData = $this->model_satuan->getDatatables();

                $data = [];
                foreach ($returnedData as $itung => $baris) {
                    $kode_urut = generate_general_code("SATUAN", $baris->id, 4);
                    $aksi = "
                        <a class='btn btn-sm btn-info' id='btn_edit'
                            data-id='$baris->id'
                            data-kode_urut='$kode_urut'
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
                        '<span class="text-center">' . $kode_urut. '</span>',
                        '<span class="text-center">' . $baris->kode . '</span>',
                        '<span class="text-center">' . $baris->nama . '</span>',
                        '<span class="text-center">' . $baris->deskripsi . '</span>',
                        '<span class="text-center">' . $aksi . '</span>'
                    ];
                }

                $output = [
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model_satuan->countNoFiltered(),
                    "recordsFiltered" => $this->model_satuan->countFiltered(),
                    "data" => $data,
                ];

                // Output to JSON format
                return $this->response->setJSON($output);
            break;

            case 'edit_data':
                $edit_id = $this->request->getPost('edit_id');

                $fetch_edit_data = $this->model_satuan->get_by_id($edit_id);

                return $this->response->setJSON($fetch_edit_data[0]);
            break;

            default:
                return $this->response->setJSON(array());
        }
    }

}
