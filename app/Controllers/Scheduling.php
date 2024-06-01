<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_jabatan;
use App\Models\Model_karyawan;
use App\Models\Model_divisi;
use App\Models\Model_entitas_usaha;

class Scheduling extends Controller
{
    protected $Model_karyawan, $Model_jabatan, $Model_divisi, $Model_entitas_usaha;
 
    function __construct(){
        $this->Model_karyawan = new Model_karyawan();
        $this->Model_jabatan = new Model_jabatan();
        $this->Model_divisi = new Model_divisi();
        $this->Model_entitas_usaha = new Model_entitas_usaha();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Data Scheduling']),
			'page_title' => view('partials/page-title', ['title' => 'HRM', 'pagetitle' => 'Data Scheduling']),
            'data_karyawan' => $this->Model_karyawan->findAll()
		];
        return view('hrm/page_list_scheduling', $data);
    }

    // ajax get ===================================================================
    // ajax get list item
    public function ajax_get_list_schedule(){
        $returnedData = $this->Model_karyawan->get_datatable_scheduling();

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
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->no_induk . '</span>',
                '<span class="text-center">' . $baris->nama . '</span>',
                '<span class="text-center">' . $baris->d1_start_time . '</span>',
                '<span class="text-center">' . $baris->d1_end_time . '</span>',
                '<span class="text-center">' . $baris->d2_start_time . '</span>',
                '<span class="text-center">' . $baris->d2_end_time . '</span>',
                '<span class="text-center">' . $baris->d3_start_time . '</span>',
                '<span class="text-center">' . $baris->d3_end_time . '</span>',
                '<span class="text-center">' . $baris->d4_start_time . '</span>',
                '<span class="text-center">' . $baris->d4_end_time . '</span>',
                '<span class="text-center">' . $baris->d5_start_time . '</span>',
                '<span class="text-center">' . $baris->d5_end_time . '</span>',
                '<span class="text-center">' . $baris->d6_start_time . '</span>',
                '<span class="text-center">' . $baris->d6_end_time . '</span>',
                '<span class="text-center">' . $baris->d7_start_time . '</span>',
                '<span class="text-center">' . $baris->d7_end_time . '</span>',
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
    public function ajax_get_schedule(){
        $id_edit = $this->request->getPost('id_edit');

        $fetch_edit_data = $this->Model_karyawan->get_schedule_by_karyawan_id($id_edit);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

}
