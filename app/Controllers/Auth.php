<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Model_user;

class Auth extends Controller
{
    protected $model_user;
 
    function __construct(){
        $this->model_user = new Model_user();
    }

    // index ===========================================================================================================
    public function index()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Login'])
		];
		return view('auth/auth-login', $data);
    }

    // show register ==================================================================================================
    public function show_register()
    {
        $data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Register'])
		];
		return view('auth/auth_register', $data);
    }
	
    // add ============================================================================================================
    public function add($kode = null)
    {
        switch ($kode) {
            case 'karyawan':
                $this->check_login();
                $data = [
                    'nama'          => $this->request->getPost('nama'), 
                    'hp'            => $this->request->getPost('hp'),
                    'alamat'        => $this->request->getPost('alamat'),
                    'id_posisi'     => $this->request->getPost('posisi'),
                    'id_service'    => activeServiceId(),
                    'created_by'    => activeId()
                ];
                
                $this->model_karyawan->reset_increment();
                $insertData = $this->model_karyawan->save($data);
                
                if ($insertData) {
                    $response = [
                        'success' => true,
                        'message' => 'Karyawan baru berhasil disimpan.'
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Gagal menyimpan Karyawan.'
                    ];
                }
                return $this->response->setJSON($response);
            break;
        }
    }
    
    // edit ===========================================================================================================
    public function edit($kode = null)
    {
        $this->check_login();
        switch ($kode) {
            case 'karyawan':
                $posisi_edit = $this->request->getPost('posisi_edit');
                
                $data = [
                    'id'        => $this->request->getPost('id_edit'),
                    'nama'      => $this->request->getPost('nama_edit'),
                    'hp'        => $this->request->getPost('hp_edit'),
                    'alamat'    => $this->request->getPost('alamat_edit')
                ];
                
                if ($posisi_edit != "") {
                    $data['id_posisi'] = $posisi_edit;
                }
                
                $this->model_karyawan->reset_increment();
                $insertData = $this->model_karyawan->save($data);

                
                if ($insertData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }
    
    // delete =========================================================================================================
    public function delete($kode = null)
    {
        $this->check_login();
        switch ($kode) {
            case 'data_pasien':
                $deleteData = $this->model_pasien->delete($this->request->getPost('id'));

                if ($deleteData) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false];
                }
                return $this->response->setJSON($response);
            break;
        }
    }

    // login =========================================================================================================
    public function login()
    {
	    $session = session();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        // $data = $this->model_user->where('username', $username)->first();
        $data = $this->model_user->get_by_username($username);
        if($data){
            $pass = $data->password;
            $authenticatePassword = password_verify($password, $pass);

            if($authenticatePassword){
                $ses_data = [
                    'active_user_id'    => $data->id,
                    'active_username'   => $data->username,
                    'active_entitas_id' => $data->id_entitas,
                    'active_role'       => $data->role_name,
                    'is_login'          => true,
                    'last_activity'     => time()
                ];
                $session->set($ses_data);
                $session->setFlashdata('message', 'Login Berhasil');
                // Log success
                error_log("Login successful for username: $username");
                return redirect()->to('/pasien-get-list');
            }else{
                $session->setFlashdata('error', 'Password Anda Salah');
                
                // Log incorrect password
                error_log("Login failed for username: $username due to incorrect password");

                return redirect()->to('/');
            }
        }else{
            $session->setFlashdata('error', 'Username Tidak Ditemukan');
            
            // Log email not found
            error_log("Login failed because username not found: $username");
            
            return redirect()->to('/');
        }
    }

    // register
    public function register(){
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];
        $this->model_user->save($data);
        return redirect()->to('/');
    }
 
    // logout 
    public function logout()
    {
        $session = session();
        $session->setFlashdata('message', 'Berhasil Logout');
        $session->destroy();
        return redirect()->to('/');
    }

}
