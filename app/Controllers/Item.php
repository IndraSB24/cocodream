<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item;
use App\Models\Model_satuan;
use App\Models\Model_kategori;
use App\Models\Model_vendors;
use App\Models\Model_brand;

class Item extends Controller
{
    protected $model_item, $Model_satuan, $Model_kategori, $Model_vendors, $Model_brand;
 
    function __construct(){
        $this->model_item = new Model_item();
        $this->Model_satuan = new Model_satuan();
        $this->Model_kategori = new Model_kategori();
        $this->Model_vendors = new Model_vendors();
        $this->Model_brand = new Model_brand();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Item']),
			'page_title' => view('partials/page-title', ['title' => 'Mater Data', 'pagetitle' => 'Data Item']),
            'data_satuan'=> $this->Model_satuan->findAll(),
            'data_jenis_item'=> $this->Model_kategori->get_item_jenis(),
            'data_kategori_item'=> $this->Model_kategori->get_item_kategori(),
            'data_supplier'=> $this->Model_vendors->findAll(),
            'data_brand'=> $this->Model_brand->findAll()
		];
        return view('data_master/item/page_list_item', $data);
    }

    // Show =================================================================================================
	public function show(request $param){
        switch($param->kode){
            case 'item_pricing':
                $data = [
                    'title_meta' => view('partials/title-meta', ['title' => 'Data Harga Jual']),
                    'page_title' => view('partials/page-title', ['title' => 'List Item', 'pagetitle' => 'Data Harga Jual'])
                ];
                return view('data_master/item/page_data_pricing', $data);
            break;
            
        }
    }
	
    // add ==================================================================================================
    public function add_item(){
        // read the file
        $uploaded_file = $this->request->getFile('file');
                
        // store the file
        if($uploaded_file){
            $store_file = $uploaded_file->move('upload/item_pict');

            $data = array_intersect_key(
                $this->request->getPost(),
                array_flip([
                    'kode_item', 'nama', 'id_kategori_jenis', 'id_satuan'
                ])
            );
            $data['image_filename'] = $uploaded_file->getName();
            $data['created_by'] = sess_activeUserId();
            $insertData = $this->model_item->save($data);
            
            // return and notif wa
            if ($store_file && $insertData){
                $response = [
                    'success' => true,
                    'message' => 'File Uploaded successfully.'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to Upload File.'
                ];
            }
   
        }else {
            $response = [
                'success' => false,
                'message' => 'No file specified.'
            ];
        }

        return json_encode($response);
    }
    
    // edit =================================================================================================
    public function edit_item(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'kode_item', 'barcode', 'nama', 'id_kategori_jenis', 'id_satuan', 'id_kategori_item',
                'id_brand', 'id_supplier', 'stok_minimum'
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
    public function ajax_get_list_item(){
        $returnedData = $this->model_item->get_datatable_main();

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

            $detail = '
                <a href="item-show-detail/'.$baris->id.'"
                    class="btn btn-sm btn-info"
                >
                    Detail
                </a>
            ';

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->kode_item . '</span>',
                '<span class="text-center">' . $baris->nama . '</span>',
                '<span class="text-center">' . $baris->nama_jenis . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->item_price) . '</span>',
                '<span class="text-center">' . $detail . '</span>',
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
    public function ajax_get_item_data(){
        $id_item = $this->request->getPost('id_item');

        $fetch_edit_data = $this->model_item->get_by_id($id_item);

        return $this->response->setJSON($fetch_edit_data[0]);
    }

    // list item
    public function ajax_get_item_list(){
        $data = [];
        $searchTerm = $this->request->getVar('term'); 

        $fetched_data = $this->model_item->search_item($searchTerm);

        foreach ($fetched_data as $itung => $baris) {
            $data[] = [
                'id' => $baris->id,
                'text' => $baris->nama.' ('.$baris->kode_item.')'
            ];
        }
        
        // Return the data in JSON format
        return $this->response->setJSON($data);
    }

}
