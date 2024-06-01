<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item_pricing;
use App\Models\Model_item;
use App\Models\Model_satuan;
use App\Models\Model_kategori;
use App\Models\Model_vendors;
use App\Models\Model_brand;
use App\Models\Model_entitas_usaha;

class Item_pricing extends Controller
{
    protected $model_item, $Model_satuan, $Model_kategori, $Model_vendors, $Model_brand, $Model_item_pricing,
        $Model_entitas_usaha;
 
    function __construct(){
        $this->model_item = new Model_item();
        $this->Model_satuan = new Model_satuan();
        $this->Model_kategori = new Model_kategori();
        $this->Model_vendors = new Model_vendors();
        $this->Model_brand = new Model_brand();
        $this->Model_item_pricing = new Model_item_pricing();
        $this->Model_entitas_usaha = new Model_entitas_usaha();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Data Harga Jual']),
			'page_title' => view('partials/page-title', ['title' => 'Item', 'pagetitle' => 'Data Harga Jual']),
            'data_satuan'=> $this->Model_satuan->findAll(),
            'data_jenis_item'=> $this->Model_kategori->get_item_jenis(),
            'data_kategori_item'=> $this->Model_kategori->get_item_kategori(),
            'data_supplier'=> $this->Model_vendors->findAll(),
            'data_brand'=> $this->Model_brand->findAll(),
            'data_item' => $this->model_item->findAll(),
            'data_entitas' => $this->Model_entitas_usaha->findAll()
		];
        return view('data_master/item/page_data_pricing', $data);
    }
	
    // add ==================================================================================================
    public function add_price(){
        // update is_active of old
        $idItem = $this->request->getPost('id_item');
        $idEntitas = $this->request->getPost('id_entitas');
        $autoInactive = $this->Model_item_pricing->autoInactive($idItem, $idEntitas);

        // insert new data
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'id_item', 'price'
            ])
        );
        $data['created_by'] = sess_activeUserId();
        $data['is_active'] = 1;
        $data['start_date'] = date('Y-m-d');

        $insertData = $this->Model_item_pricing->save($data);
        
        if ($insertData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // edit =================================================================================================
    public function edit_item(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'kode_item', 'barcode', 'nama', 'id_kategori_jenis', 'id_satuan', 'id_kategori_item',
                'id_brand', 'id_supplier', 'stok_minimum', 'harga_dasar'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $insertData = $this->model_item->save($data);
        
        if ($insertData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }
    
    // delete ===============================================================================================
    public function delete_item()
    {
        $deleteData = $this->model_item->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return $this->response->setJSON($response);
    }

    // ajax get list item
    public function ajax_get_list_item_pricing(){
        $returnedData = $this->Model_item_pricing->get_datatable_main();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $status = $baris->is_active == 1 ?
                '
                    <span class="badge badge-xl badge-soft-success">
                        Active
                    </span>
                ' :
                '
                    <span class="badge badge-xl badge-soft-danger">
                        Not Active
                    </span>
                '
            ;

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->item_code . '</span>',
                '<span class="text-center">' . $baris->item_name . '</span>',
                '<span class="text-center">' . thousand_separator($baris->price) . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>',
                '<span class="text-center">' . indoDate($baris->start_date)	 . '</span>',
                '<span class="text-center">' . $status . '</span>'
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
