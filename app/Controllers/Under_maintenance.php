<?php

namespace App\Controllers;

use App\Models\Model_pasien;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class Under_maintenance extends Controller
{
    protected $model_pasien;
 
    function __construct(){
        $this->model_pasien = new Model_pasien();
    }

    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Maintenance']),
			'page_title' => view('partials/page-title', ['title' => 'Maintenance', 'pagetitle' => 'Maintenance'])
		];
		return view('pages-maintenance', $data);
    }

    

}
