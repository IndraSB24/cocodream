<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_transaksi;

class Dashboard extends Controller
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
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Dashboard']),
            'transaction_data' => $this->Model_transaksi->get_transaction_summary()
		];
		return view('page_dashboard', $data);
    }

    

}
