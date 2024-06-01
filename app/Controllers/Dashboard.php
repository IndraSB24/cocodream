<?php

namespace App\Controllers;

use App\Models\Model_transaksi;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class Dashboard extends Controller
{
    protected $model_pasien;
 
    function __construct(){
        $this->model_transaksi = new Model_transaksi();
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
			'page_title' => view('partials/page-title', ['title' => 'Clarisa', 'pagetitle' => 'Dashboard'])
		];
		return view('index', $data);
    }

    

}
