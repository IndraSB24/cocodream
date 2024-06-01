<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_cash_drawer;
use App\Models\Model_cash_drawer_detail;
use App\Models\Model_provinsi;

class Cash_drawer extends Controller
{
    protected $model_cash_drawer, $Model_provinsi, $Model_cash_drawer_detail;
 
    function __construct(){
        $this->model_satuan = new Model_cash_drawer();
        $this->Model_provinsi = new Model_provinsi();
        $this->Model_cash_drawer_detail = new Model_cash_drawer_detail();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Cash Drawer']),
			'page_title' => view('partials/page-title', ['title' => 'POS', 'pagetitle' => 'Data Cash Drawer']),
            'list_provinsi' => $this->Model_provinsi->findAll(),
		];
        return view('cash_drawer/page_list_cash_drawer', $data);
    }

    // show detail cash drawer
    public function show_detail($id_entitas, $for_date){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Detail Cash Drawer']),
			'page_title' => view('partials/page-title', ['title' => 'POS', 'pagetitle' => 'Data Detail Cash Drawer']),
            'list_provinsi' => $this->Model_provinsi->findAll(),
            'id_entitas' => $id_entitas,
            'for_date' => $for_date
		];
        return view('cash_drawer/page_list_cash_drawer_detail', $data);
    }

    // ajax get list cashdrawer
    public function ajax_get_list_cashdrawer(){
        $returnedData = $this->Model_cash_drawer_detail->get_datatable_list_cashdrawer();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $aksi = '
                <a href="cashdrawer-get-detail/'.$baris->id_entitas.'/'.$baris->for_date.'"
                    class="btn btn-sm btn-info"
                >
                    Detail
                </a>
            ';

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->for_date . '</span>',
                '<span class="text-center">' . $baris->nama_entitas . '</span>',
                '<span class="text-center">' . $baris->kegiatan_total . '</span>',
                '<span class="text-center">' . $baris->total_debit . '</span>',
                '<span class="text-center">' . $baris->total_credit . '</span>',
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

    // ajax get list cashdrawer detail
    public function ajax_get_list_cashdrawer_detail($id_entitas, $for_date){
        $returnedData = $this->Model_cash_drawer_detail->get_datatable_list_cashdrawer_detail($id_entitas, $for_date);

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $nominal_credit = $baris->jenis=='credit' ? $baris->nominal : '-';
            $nominal_debit = $baris->jenis=='debit' ? $baris->nominal : '-';

            $nama_user = $baris->nama_karyawan ?: ($baris->username_user ?: '-');

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->for_date . '</span>',
                '<span class="text-center">' . $baris->deskripsi . '</span>',
                '<span class="text-center">' . $nominal_debit . '</span>',
                '<span class="text-center">' . $nominal_credit . '</span>',
                '<span class="text-center">' . $nama_user . '</span>'
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

    // add cashdrawer detail =================================================================================
    public function add_cashdrawer_detail(){
        $cashDrawerDetail = $this->request->getPost('cashdrawer_detail');
        $for_date = $this->request->getPost('for_date');
        
        if (!empty($cashDrawerDetail) && is_array($cashDrawerDetail)) {
            foreach ($cashDrawerDetail as $value) {
                $payload = [
                    'for_date' =>  $for_date,
                    'deskripsi' => $value['deskripsi'],
                    'id_entitas' => 1
                ];

                if($value['debit'] != 'NaN'){
                    $payload['jenis'] = 'debit';
                    $payload['nominal'] = $value['debit'];
                }

                if($value['credit'] != 'NaN'){
                    $payload['jenis'] = 'credit';
                    $payload['nominal'] = $value['credit'];
                }

                $add_detail = $this->Model_cash_drawer_detail->save($payload);

                if($add_detail){
                    $isDone = true;
                }else{
                    $isDone = false;
                }
            }
        }

        if ($isDone) {
            $response = [
                'success' => true
            ];
        } else {
            $response = [
                'success' => false
            ];
        }
        return $this->response->setJSON($response);
    }

}
