<?php

namespace App\Controllers;

use App\Models\Model_transaksi;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class Laporan extends Controller
{
    protected $Model_transaksi;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Laporan Penjualan'])
		];
		return view('laporan/page_laporan_penjualan', $data);
    }

    // ajax get laporan transaksi
    public function ajax_get_laporan_transaksi(){
        $returnedData = $this->Model_transaksi->get_datatable_laporan_penjualan();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $detail = '
                <a id="btn_show_detail" href="transaksi-show-detail/'.$baris->id.'"
                    class="btn btn-sm btn-info"
                >
                    Detail
                </a>
            ';

            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . $baris->no_invoice . '</span>',
                '<span class="text-center">' . $baris->transaction_date . '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->total_nominal). '</span>',
                '<span class="text-center">' . $baris->payment_method . '</span>',
                '<span class="text-center">' . $baris->payment_status . '</span>',
                '<span class="text-center">' . $detail . '</span>'
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
