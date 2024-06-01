<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_user extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = ['username', 'email', 'password', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function countNoFiltered()
    {
        $this->select('
            *
        ')
        ->where('id NOT IN (0, 1, 2)')
        ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // get
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'username'
        ];
        $column_orderable = [
            'id', 'username'
        ];

        $this->select('
            *
        ')
        ->where('id NOT IN (0, 1, 2)')
        ->where('deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
            foreach ($column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); 
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($column_searchable) - 1 == $i) {
                    $this->groupEnd(); 
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $column_orderable[$request->getPost('order')[0]['column']];
            $orderDirection = $request->getPost('order')[0]['dir'];
            $this->orderBy($orderColumn, $orderDirection);
        } else {
            $this->orderBy('id', 'ASC');
        }

        if ($request->getPost('length') != -1) {
            $this->limit($request->getPost('length'), $request->getPost('start'));
        }

        // result set
        $result['return_data'] = $this->get()->getResult();
        $result['count_filtered'] = $this->countAllResults();
        $result['count_all'] = $this->countNoFiltered();

        return $result;
    }

    // get by username
    public function get_by_username($username){
        $this->select('
            user.*,
            k.id_entitas as id_entitas
        ')
        ->join('karyawan k', 'k.id_user=user.id', 'LEFT')
        ->where('user.username', $username);
        
        return $this->get()->getRow();
    }

    // add user
    public function addUser(array $data)
    {
        // Hash the password before saving
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->insert($data);
    }

}
