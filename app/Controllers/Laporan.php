<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_transaksi;
use App\Models\Model_cash_drawer_detail;
use App\Models\Model_transaksi_detail;

class Laporan extends Controller
{
    protected $Model_transaksi, $Model_cash_drawer_detail;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_cash_drawer_detail = new Model_cash_drawer_detail();
        $this->Model_transaksi_detail = new Model_transaksi_detail();
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

    public function laporan_show_penjualan_produk()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Laporan Penjualan Produk']),
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Laporan Penjualan Produk'])
		];
		return view('laporan/page_laporan_stock', $data);
    }

    // ajax get laporan transaksi
    public function ajax_get_laporan_transaksi(){
        $returnedData = $this->Model_transaksi->get_datatable_laporan_penjualan();
        $total_penjualan = 0;
        $total_hpp = 0;

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $total_penjualan += $baris->total_nominal;
            $total_hpp += $baris->total_hpp;

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
            "recordsFiltered" => $returnedData['count_filtered'],
            "data" => $data,
            "totalPenjualan" => $total_penjualan,
            "totalTransaksi" => $returnedData['count_filtered'],
            "rata2Penjualan" => $returnedData['count_filtered'] > 0 ? floatval($total_penjualan / $returnedData['count_filtered']) : 0,
            "totalHPP" => $total_hpp
        ];        

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    // ajax get laporan transaksi
    public function ajax_get_laporan_pengeluaran(){
        $returnedData = $this->Model_cash_drawer_detail->get_datatable_laporan_pengeluaran();
        $total_pengeluaran = 0;
        $total_kegiatan = 0;

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $total_pengeluaran += $baris->total_credit;
            $total_kegiatan += $baris->kegiatan_total;

            $detail = '
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
                '<span class="text-center">' . thousand_separator($baris->kegiatan_total). '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->total_debit). '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->total_credit). '</span>',
                '<span class="text-center">' . $detail . '</span>'
            ];
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $returnedData['count_all'],
            "recordsFiltered" => $returnedData['count_filtered'],
            "data" => $data,
            "totalPengeluaran" => $total_pengeluaran,
            "totalKegiatan" => $total_kegiatan,
            "rata2Pengeluaran" => $total_kegiatan > 0 ? floatval($total_pengeluaran / $total_kegiatan) : 0
        ];        

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    // ajax get laporan transaksi per produk
    public function ajaxGetReportByProduct(){
        $returnedData = $this->Model_transaksi_detail->getDatatableReportByProduct();

        $data = [];
        foreach ($returnedData['return_data'] as $itung => $baris) {
            $data[] = [
                '<span class="text-center">' . ($itung + 1) . '</span>',
                '<span class="text-center">' . indoDate($baris->transaksi_date) . '</span>',
                '<span class="text-center">' . $baris->nama_item . '</span>',
                '<span class="text-center">' . thousand_separator($baris->total_quantity). '</span>',
                '<span class="text-center">Rp. ' . thousand_separator($baris->total_price). '</span>'
            ];
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $returnedData['count_all'],
            "recordsFiltered" => $returnedData['count_filtered'],
            "data" => $data
        ];        

        // Output to JSON format
        return $this->response->setJSON($output);
    }

    

}
