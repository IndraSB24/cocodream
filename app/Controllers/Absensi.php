<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_kategori;
use App\Models\Model_absensi;

class Absensi extends Controller
{
    protected $Model_kategori, $Model_absensi;
 
    function __construct(){
        helper(['session_helper', 'formatting_helper']);
        $this->Model_kategori = new Model_kategori();
        $this->Model_absensi = new Model_absensi();
    }

    public function login_check()
    {
        if (!sess_activeUserId()) {
            return redirect()->to('/');
        }else{
            return true;
        }
    }

    public function index(){
        $this->login_check();
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Absensi']),
			'page_title' => view('partials/page-title', ['title' => 'HRM', 'pagetitle' => 'Absensi']),
            'today_data' => $this->Model_absensi->get_today_by_user(sess_activeUserId())
		];
        return view('hrm/page_absensi', $data);
    }

    public function do_absen($kode){
        $save_data = false;
        $lat = $this->request->getPost('latitude');
        $long = $this->request->getPost('longitude');

        switch ($kode) {
            case 'masuk':
                $data = [
                    'id_user' => sess_activeUserId(),
                    'waktu_masuk' => date('Y-m-d H:i:s'),
                    'status' => 'masuk',
                    'created_by' => sess_activeUserId(),
                    'masuk_lat' => $lat,
                    'masuk_long' => $long
                ];
                $save_data = $this->Model_absensi->save($data);
                break;

            case 'keluar':
                $save_data = $this->Model_absensi->do_absen_out(sess_activeUserId(), $lat, $long);
                break;
        }

        if ($save_data) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // show absensi list
    public function show_absensi_list($id_user=null){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Rekap Absensi']),
			'page_title' => view('partials/page-title', ['title' => 'HRM', 'pagetitle' => 'Rekap Absensi']),
            'id_user' => $id_user
		];
        return view('hrm/page_list_absensi', $data);
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
    public function ajax_get_list_absensi(){
        $returnedData = $this->Model_absensi->get_datatable_main();

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
                '<span class="text-center">' . $baris->nama_user . '</span>',
                '<span class="text-center">' . $baris->waktu_masuk . '</span>',
                '<span class="text-center">' . $baris->waktu_keluar . '</span>',
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
