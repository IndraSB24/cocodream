<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item_restock;
use App\Models\Model_item_transaksi_stock;

class Item_restock extends Controller
{
    protected $Model_item_restock, $Model_item_transaksi_stock;
 
    function __construct(){
        $this->Model_item_restock = new Model_item_restock();
        $this->Model_item_transaksi_stock = new Model_item_transaksi_stock();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Item Restock']),
			'page_title' => view('partials/page-title', ['title' => 'Inventory', 'pagetitle' => 'Data Item Restock'])
		];
        return view('inventory/page_item_restock', $data);
    }
	
    // add ==================================================================================================
    public function add(){
        $itemDetail = $this->request->getPost('item_detail');
        $allInsertionsSuccessful = true;

        if (!empty($itemDetails) && is_array($itemDetails)) {
            foreach ($itemDetails as $item) {
                // Insert transaksi detail
                $payload_restock = [
                    'type' => 'pembelian',
                    'id_item' => $item['id_item'],
                    'quantity' => $item['jumlah'],
                    'unit' => $item['satuan'],
                    'price' => $item['harga'],
                    'restock_date' => $this->request->getPost('restock_date')
                ];
                $insertedRestockId = $this->Model_item_restock->insertWithReturnId($payload_restock);

                if ($insertedRestockId) {
                    // Inject invoice code
                    $data_restock_update = [
                        'code' => generate_general_code('RST', $insertedRestockId, 9)
                    ];
                    $updateRestock = $this->Model_item_restock->update($insertedRestockId, $data_restock_update);

                    // Insert transaksi stock
                    $payload_add_transaksi_stock = [
                        'id_item' => $item['id_item'],
                        'jumlah' => -$item['jumlah'], 
                        'jenis' => 'masuk', 
                        'kegiatan' => 'restock',
                        'id_kegiatan' => $insertedRestockId, 
                        'tanggal_kegiatan' => $this->request->getPost('restock_date'),
                        'id_entitas' => sess_activeEntitasId(),
                        'created_by' => sess_activeUserId()
                    ];
                    $this->Model_item_transaksi_stock->addTransaksiStock($payload_add_transaksi_stock);
                } else {
                    // If any insertion fails, mark allInsertionsSuccessful as false
                    $allInsertionsSuccessful = false;
                    break;
                }
            }
        } else {
            // Handle the case where itemDetails is empty or not an array
            $allInsertionsSuccessful = false;
        }
   
        if ($allInsertionsSuccessful) {
            $response = [
                'success' => true,
                "isRedirect" => true
            ];
        } else {
            $response = [
                'success' => false
            ];
        }

        return json_encode($response);
    }
    
    // edit =================================================================================================
    public function edit(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'name', 'description'
            ])
        );
        $data['id'] = $this->request->getPost('edit_id');
        $data['created_by'] = sess_activeUserId();

        $updateData = $this->Model_distribution_channel->save($data);
        
        if ($updateData) {
            $response = ['success' => true];
        } else {
            $response = [
                'success' => false,
                'message' => 'failed to insert'
            ];
        }
        return json_encode($response);
    }
    
    // delete ===============================================================================================
    public function delete()
    {
        $deleteData = $this->Model_distribution_channel->delete($this->request->getPost('id'));

        if ($deleteData) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        return json_encode($response);
    }

    // ajax get list item
    public function ajax_get_list_main(){
        $returnedData = $this->Model_item_restock->get_datatable_main();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $aksi = "
                <a class='btn btn-sm btn-danger' id='btn_delete' 
                    data-id='$baris->id'
                    data-code='$baris->code'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->code . '</span>',
                '<span class="text-center">' . $baris->type . '</span>',
                '<span class="text-center">' . $baris->item_name .' ('.$baris->item_code.')'. '</span>',
                '<span class="text-center">' . $baris->quantity . '</span>',
                '<span class="text-center">' . $baris->unit . '</span>',
                '<span class="text-center">' . $baris->price . '</span>',
                '<span class="text-center">' . $baris->restock_date . '</span>',
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

}
