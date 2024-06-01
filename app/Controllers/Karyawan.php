<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_jabatan;
use App\Models\Model_karyawan;
use App\Models\Model_divisi;
use App\Models\Model_entitas_usaha;

class Karyawan extends Controller
{
    protected $model_karyawan, $Model_jabatan, $Model_divisi, $Model_entitas_usaha;
 
    function __construct(){
        $this->model_karyawan = new Model_karyawan();
        $this->Model_jabatan = new Model_jabatan();
        $this->Model_divisi = new Model_divisi();
        $this->Model_entitas_usaha = new Model_entitas_usaha();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Karyawan']),
			'page_title' => view('partials/page-title', ['title' => 'Master Data', 'pagetitle' => 'List Karyawan']),
            'data_jabatan' => $this->Model_jabatan->findAll(),
            'data_divisi' => $this->Model_divisi->findAll(),
            'data_entitas' => $this->Model_entitas_usaha->findAll()
		];
        return view('data_master/karyawan/page_list_karyawan', $data);
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
    public function add_karyawan()
    {
        
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'no_induk', 'nama', 'hp', 'id_jabatan', 'id_divisi', 'id_entitas',
            ])
        );

        $data['created_by'] = sess_activeUserId();
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
    public function delete_karyawan()
    {
        $deleteData = $this->model_karyawan->delete($this->request->getPost('id'));

                if ($deleteData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
    }

    // ajax get =======================================================================================================
    public function ajax_get($kode="")
    {
        switch ($kode) {
            case 'list_karyawan':
                $returnedData = $this->model_karyawan->getDatatables();

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
                            data-path='".base_url('karyawan/delete/data_karyawan')."'
                        > 
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    ";

                    $jabatan = $baris->nama_jabatan!=NULL ? $baris->nama_jabatan : 'Not Set';
                    $divisi = $baris->nama_divisi!=NULL ? $baris->nama_divisi : 'Not Set';
                    $entitas = $baris->nama_entitas!=NULL ? $baris->nama_entitas : 'Not Set';

                    $data[] = [
                        '<span class="text-center">' . $itung+1 . '</span>',
                        '<span class="text-center">' . $baris->no_induk . '</span>',
                        '<span class="text-center">' . $baris->nama ?: "no name" . '</span>',
                        '<span class="text-center">' . $baris->hp . '</span>',
                        '<span class="text-center">' . $jabatan . '</span>',
                        '<span class="text-center">' . $divisi . '</span>',
                        '<span class="text-center">' . $entitas . '</span>',
                        $aksi
                    ];
                }

                $output = [
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model_karyawan->countNoFiltered(),
                    "recordsFiltered" => $this->model_karyawan->countFiltered(),
                    "data" => $data,
                ];

                // Output to JSON format
                return $this->response->setJSON($output);
            break;

            default:
                return $this->response->setJSON(array());
        }
    }

     // ajax get data edit
     public function ajax_get_karyawan_data(){
        $id_karyawan = $this->request->getPost('id_karyawan');

        $fetch_edit_data = $this->model_karyawan->get_by_id($id_karyawan);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
