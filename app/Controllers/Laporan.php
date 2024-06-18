<?php

namespace App\Controllers;

use App\Models\Model_transaksi;
use App\Models\Model_cash_drawer;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class Laporan extends Controller
{
    protected $Model_transaksi;
    protected $Model_cash_drawer;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_cash_drawer = new Model_cash_drawer();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Laporan Penjualan']),
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Laporan Penjualan'])
		];
		return view('laporan/page_laporan_penjualan', $data);
    }

    public function laporan_show_pengeluaran()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Laporan Pengeluaran']),
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Laporan Pengeluaran'])
		];
		return view('laporan/page_laporan_pengeluaran', $data);
    }

    // ajax get laporan transaksi
    public function ajax_get_laporan_transaksi(){
        $returnedData = $this->Model_transaksi->get_datatable_laporan_penjualan();
        $total_penjualan = 0;

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $total_penjualan += $baris->total_nominal;
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
            "recordsTotal" => $returnedData['count_all'],
            "recordsFiltered" => count($data),
            "data" => $data,
            "totalPenjualan" => $total_penjualan,
            "totalTransaksi" => count($data),
            "rata2Penjualan" => count($data) > 0 ? floatval($total_penjualan / count($data)) : 0
        ];        

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    

}
