<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_transaksi;
use App\Models\Model_cash_drawer_detail;
use App\Models\Model_transaksi_detail;

class Dashboard extends Controller
{
    protected $Model_transaksi, $Model_cash_drawer_detail, $Model_transaksi_detail;
 
    function __construct(){
        $this->Model_transaksi = new Model_transaksi();
        $this->Model_cash_drawer_detail = new Model_cash_drawer_detail();
        $this->Model_transaksi_detail = new Model_transaksi_detail();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index()
    {
        $from_date = $this->request->getPost('filterDateFrom') ?? date('Y-m-d');
        $to_date = $this->request->getPost('filterDateUntil') ?? date('Y-m-d');

        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Dashboard']),
            'transaction_data' => $this->Model_transaksi->get_transaction_summary(),
            'cashdrawer_data' => $this->Model_cash_drawer_detail->get_total_cashdrawer(),
            'most_product' =>$this->Model_transaksi_detail->getMostProduct(),
            'filter_from_date' => $from_date,
            'filter_to_date' => $to_date
		];
		return view('page_dashboard', $data);
    }

    

}
