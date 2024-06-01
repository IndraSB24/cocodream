<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item_stock_management;
use App\Models\Model_item;
use App\Models\Model_item_restock;
use App\Models\Model_entitas_usaha;
use App\Models\Model_provinsi;
use App\Models\Model_kota;

class Item_stock_management extends Controller
{
    protected $Model_item_stock_management, $Model_item, $Model_item_restock, $Model_entitas_usaha,
        $Model_kota, $Model_provinsi;
 
    function __construct(){
        $this->Model_item_stock_management = new Model_item_stock_management();
        $this->Model_item = new Model_item();
        $this->Model_item_restock = new Model_item_restock();
        $this->Model_entitas_usaha = new Model_entitas_usaha();
        $this->Model_provinsi = new Model_provinsi();
        $this->Model_kota = new Model_kota();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Data Stock']),
			'page_title' => view('partials/page-title', ['title' => 'Inventory', 'pagetitle' => 'Data Stock']),
            'data_item' => $this->Model_item->findAll(),
            'data_entitas_usaha' => $this->Model_entitas_usaha->findAll(),
            'list_provinsi' => $this->Model_provinsi->findAll(),
            'list_kota' => $this->Model_kota->findAll()
		];
        return view('inventory/page_data_stock', $data);
    }

    // show stock management
    public function show_stock_management()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Managemen Stok']),
			'page_title' => view('partials/page-title', ['title' => 'Inventory', 'pagetitle' => 'Managemen Stok']),
            'data_item' => $this->Model_item->findAll(),
            'data_entitas_usaha' => $this->Model_entitas_usaha->findAll(),
            'list_provinsi' => $this->Model_provinsi->findAll(),
            'list_kota' => $this->Model_kota->findAll()
		];
        return view('inventory/page_data_stock', $data);
    }

    // ajax get ===================================================================
    // ajax get list item
    public function ajax_get_list_stock(){
        $returnedData = $this->Model_item->get_datatable_rekap_stock();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $row_data = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->kode_item . '</span>',
                '<span class="text-center">' . $baris->nama . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>'
            ];

            foreach ($returnedData['list_entitas_id'] as $list) {
                $row_data[] = '<span class="text-center">' . $baris->{'quantity_entity_' . $list} . '</span>';
            }

            $data[] = $row_data;
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
