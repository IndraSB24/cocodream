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

    // ajax for datatable list_pasien
    protected $column_searchable = ['username'];
    protected $column_orderable = ['id', 'username'];
    public function getDatatables()
    {
        $request = service('request');

        $this->select('
                user.*,
                k.nama as nama_karyawan
            ')
            ->join('karyawan k', 'k.id_user=user.id')
            ->where('user.id NOT IN (0, 1, 2)')
            ->where('user.deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0; // Initialize loop counter
            foreach ($this->column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); // Open bracket for OR conditions
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($this->column_searchable) - 1 == $i) {
                    $this->groupEnd(); // Close bracket for OR conditions
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $this->column_orderable[$request->getPost('order')[0]['column']];
            $orderDirection = $request->getPost('order')[0]['dir'];
            $this->orderBy($orderColumn, $orderDirection);
        } else {
            $this->orderBy('id', 'ASC');
        }

        if ($request->getPost('length') != -1) {
            $this->limit($request->getPost('length'), $request->getPost('start'));
        }

        return $this->get()->getResult();
    }

    public function countFiltered()
    {
        $request = service('request');

        $this->select('*')
            ->where('id NOT IN (0, 1, 2)')
            ->where('deleted_at', NULL);


        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $this->groupStart();
            foreach ($this->column_searchable as $field) {
                $this->like($field, $searchValue);
            }
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    public function countNoFiltered()
    {
        $this->select('*')
            ->where('id NOT IN (0, 1, 2)')
            ->where('deleted_at', NULL);

        return $this->countAllResults();
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

}
