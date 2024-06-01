<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_pasien;
use App\Models\Model_provinsi;
use App\Models\Model_kota;

class Pasien extends Controller
{
    protected $model_pasien, $model_provinsi, $model_kota;
 
    function __construct(){
        $this->model_pasien = new Model_pasien();
        $this->model_provinsi = new Model_provinsi();
        $this->model_kota = new Model_kota();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Pasien']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Pasien']),
            'list_provinsi' => $this->model_provinsi->findAll(),
            'list_kota' => $this->model_kota->findAll()
		];
        return view('data_master/pasien/page_list_pasien', $data);
    }

    // Show ================================================================================================
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

    // add pasien ==========================================================================================
    public function add_pasien(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'nama', 'alamat', 'phone', 'id_kota', 'tanggal_lahir'
            ])
        );
        // $data['tanggal_lahir'] = db_date_format_from_datepicker($this->request->getPost('tanggal_lahir'));
        $data['created_by'] = sess_activeUserId();
        
        $insertDataWithId = $this->model_pasien->insertWithReturnId($data);
        
        if ($insertDataWithId) {
            // inject code
            $data_update_pasien = [
                'id' => $insertDataWithId,
                'kode_pasien' => generate_general_code('PL', $insertDataWithId, 8),
                'no_mr' => generate_general_code('MR', $insertDataWithId, 8)
            ];
            $this->model_pasien->save($data_update_pasien);

            $response = [
                'success' => true,
                'message' => 'Pasien baru berhasil disimpan.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Gagal menyimpan Pasien.'
            ];
        }
        return $this->response->setJSON($response);
    }

    // edit =================================================================================================
    public function edit_pasien(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'nama', 'alamat', 'phone', 'id_kota', 'tanggal_lahir'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $insertData = $this->model_pasien->save($data);
        
        if ($insertData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // delete pasien
    public function delete_pasien(){
        $deleteData = $this->model_pasien->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // ajax get =============================================================================================
    public function ajax_get($kode="")
    {
        switch ($kode) {
            case 'list_pasien':
                $returnedData = $this->model_pasien->getDatatables();

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
                        '<span class="text-center">' . ($itung+1) . '</span>',
                        '<span class="text-center text-uppercase">' . $baris->kode_pasien . '</span>',
                        '<span class="text-center text-capitalize">' . $baris->nama . '</span>',
                        '<span class="text-center">' . $baris->tanggal_lahir . '</span>',
                        '<span class="text-center text-capitalize">' . $baris->nama_kota . '</span>',
                        '<span class="text-center text-capitalize">' . $baris->alamat . '</span>',
                        '<span class="text-center">' . $baris->phone . '</span>',
                        $aksi
                    ];
                }

                $output = [
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model_pasien->countNoFiltered(),
                    "recordsFiltered" => $this->model_pasien->countFiltered(),
                    "data" => $data,
                ];

                // Output to JSON format
                return $this->response->setJSON($output);
            break;

            case'search_pasien':
                $keyword = $this->request->getVar('q');

                $results = $this->model_pasien->search_pasien($keyword);

                return $this->response->setJSON($results);
            break;

            default:
                return $this->response->setJSON(array());
        }
    }

    // list pasien
    public function ajax_get_pasien(){
        $data = [];
        $searchTerm = $this->request->getVar('term'); 

        $fetched_data = $this->model_pasien->search_pasien($searchTerm);

        foreach ($fetched_data as $itung => $baris) {
            $data[] = ['id' => $baris->id, 'text' => $baris->nama.' ('.$baris->kode_pasien.')'];
        }
        
        // Return the data in JSON format
        return $this->response->setJSON($data);
    }

    // ajax get data edit
    public function ajax_get_pasien_data(){
        $id_pasien = $this->request->getPost('id_pasien');

        $fetch_edit_data = $this->model_pasien->get_by_id($id_pasien);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
