<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_user;
use App\Models\Model_roles;
use App\Models\Model_entitas_usaha;

class User extends Controller
{
    protected $model_user, $Model_roles, $Model_entitas_usaha;
 
    function __construct(){
        $this->model_user = new Model_user();
        $this->Model_roles = new Model_roles();
        $this->Model_entitas_usaha = new Model_entitas_usaha();
        helper(['session_helper', 'formatting_helper']);
    }

    public function index(){
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'List User']),
			'page_title' => view('partials/page-title', ['title' => 'Data User', 'pagetitle' => 'List User']),
            'list_role' => $this->Model_roles->get_by_kode('item_jenis'),
            'list_entitas' => $this->Model_entitas_usaha->findAll()
		];
        return view('data_user/page_list_user', $data);
    }

    // create user
    public function createUser(){
        $data = array_intersect_key(
            $this->request->getPost(),
            array_flip([
                'username', 'nama', 'email', 'password', 'id_entitas', 'id_role'
            ])
        );
        $data['created_by'] = sess_activeUserId();

        $addUser = $this->model_user->addUser($data);

        if ($addUser) {
            $response = [
                'success' => true
            ];
        } else {
            $response = [
                'success' => false
            ];
        }
        return $this->response->setJSON($response);
    }

    // ajax get list cashdrawer
    public function ajax_get_list_user(){
        $returnedData = $this->model_user->get_datatable_main();

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
                    data-username='$baris->username'
                > 
                    <i class='fas fa-trash-alt'></i>
                </a>
            ";

            $is_active = $baris->is_active==1 ?
                '<span class="badge bg-success p-2">Active</span>' :
                '<span class="badge bg-danger p-2">Not Active</span>';

            $notset = "Not Set";

            $data[] = [
                '<span class="text-center">' . ($itung+1) . '</span>',
                '<span class="text-center">' . $baris->username . '</span>',
                '<span class="text-center"> no name </span>',
                '<span class="text-center">' . $notset . '</span>',
                '<span class="text-center">' . $notset . '</span>',
                '<span class="text-center">' . $is_active . '</span>',
                $aksi
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
