<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_item;
use App\Models\Model_satuan;
use App\Models\Model_kategori;
use App\Models\Model_vendors;
use App\Models\Model_brand;
use App\Models\Model_item_transaksi_stock;
use App\Models\Model_provinsi;
use App\Models\Model_kota;

class Item_transaksi_stock extends Controller
{
    protected $model_item, $Model_satuan, $Model_kategori, $Model_vendors, $Model_brand,
        $Model_item_transaksi_stock;
 
    function __construct(){
        $this->model_item = new Model_item();
        $this->Model_satuan = new Model_satuan();
        $this->Model_kategori = new Model_kategori();
        $this->Model_vendors = new Model_vendors();
        $this->Model_brand = new Model_brand();
        $this->Model_item_transaksi_stock = new Model_item_transaksi_stock();
        $this->model_provinsi = new Model_provinsi();
        $this->model_kota = new Model_kota();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List Transaksi Stok Item']),
			'page_title' => view('partials/page-title', ['title' => 'Inventory', 'pagetitle' => 'List Transaksi Stok Item']),
            'data_satuan'=> $this->Model_satuan->findAll(),
            'data_jenis_item'=> $this->Model_kategori->get_item_jenis(),
            'data_kategori_item'=> $this->Model_kategori->get_item_kategori(),
            'data_supplier'=> $this->Model_vendors->findAll(),
            'data_brand'=> $this->Model_brand->findAll(),
            'list_provinsi' => $this->model_provinsi->findAll(),
            'list_kota' => $this->model_kota->findAll()
		];
        return view('inventory/page_item_transaksi_stock', $data);
    }

    // ajax get list item
    public function ajax_get_list_transaksi_stock(){
        $returnedData = $this->Model_item_transaksi_stock->get_datatable_main();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
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
                '<span class="text-center">' . $baris->nama_item . '</span>',
                '<span class="text-center">' . $baris->jenis . '</span>',
                '<span class="text-center">' . makePositive($baris->jumlah) . '</span>',
                '<span class="text-center">' . $baris->nama_satuan . '</span>',
                '<span class="text-center">' . $baris->kegiatan . '</span>',
                '<span class="text-center">' . $baris->nama_entitas . '</span>',
                '<span class="text-center">' . indoDate($baris->tanggal_kegiatan) . '</span>',
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
