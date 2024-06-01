<?php

namespace App\Controllers;

use App\Models\Model_user;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class User extends Controller
{
    protected $model_user;
 
    function __construct(){
        $this->model_user = new Model_user();
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List User']),
			'page_title' => view('partials/page-title', ['title' => 'Data User', 'pagetitle' => 'List User'])
		];
        return view('data_user/page_list_user', $data);
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
    public function add($kode = null)
    {
        switch ($kode) {
            case 'karyawan':
                $this->check_login();
                $data = [
                    'nama'          => $this->request->getPost('nama'), 
                    'hp'            => $this->request->getPost('hp'),
                    'alamat'        => $this->request->getPost('alamat'),
                    'id_posisi'     => $this->request->getPost('posisi'),
                    'id_service'    => activeServiceId(),
                    'created_by'    => activeId()
                ];
                
                $this->model_karyawan->reset_increment();
                $insertData = $this->model_karyawan->save($data);
                
                if ($insertData) {
                    $response = [
                        'success' => true,
                        'message' => 'Karyawan baru berhasil disimpan.'
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Gagal menyimpan Karyawan.'
                    ];
                }
                return $this->response->setJSON($response);
            break;
        }
    }
    
    // edit ================================================================================================================================================================
    public function edit($kode = null)
    {
        $this->check_login();
        switch ($kode) {
            case 'karyawan':
                $posisi_edit = $this->request->getPost('posisi_edit');
                
                $data = [
                    'id'        => $this->request->getPost('id_edit'),
                    'nama'      => $this->request->getPost('nama_edit'),
                    'hp'        => $this->request->getPost('hp_edit'),
                    'alamat'    => $this->request->getPost('alamat_edit')
                ];
                
                if ($posisi_edit != "") {
                    $data['id_posisi'] = $posisi_edit;
                }
                
                $this->model_karyawan->reset_increment();
                $insertData = $this->model_karyawan->save($data);

                
                if ($insertData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }
    
    // delete ==============================================================================================================================================================
    public function delete($kode = null)
    {
        $this->check_login();
        switch ($kode) {
            case 'data_pasien':
                $deleteData = $this->model_pasien->delete($this->request->getPost('id'));

                if ($deleteData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }

    // ajax get list cashdrawer
    public function ajax_get_list_user(){
        $returnedData = $this->model_user->get_datatable_main();

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
                    data-username='$baris->username'
                    data-path='".base_url('user/delete/data_user')."'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $is_active = $baris->is_active==1 ?
                '<span class="badge bg-success p-2">Active</span>' :
                '<span class="badge bg-danger p-2">Not Active</span>';

            $notset = "Not Set";

            $data[] = [
                '<span class="text-center">' . ($itung+1) . '</span>',
                '<span class="text-center">' . $baris->username . '</span>',
                '<span class="text-center">' . $baris->nama_karyawan ?: "no name" . '</span>',
                '<span class="text-center">' . $notset . '</span>',
                '<span class="text-center">' . $notset . '</span>',
                '<span class="text-center">' . $is_active . '</span>',
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
