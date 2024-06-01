<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_entitas_usaha extends Model
{
    protected $table      = 'entitas';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = ['nama', 'id_entitas_tipe', 'id_kota', 'alamat', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function countNoFiltered()
    {
        $this->select('
            *
        ')
        ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // get
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'entitas.nama', 'et.nama', 'entitas.alamat', 'lk.nama','lp.nama'
        ];
        $column_orderable = [
            'id', 'nama', 'nama_entitas_tipe', 'alamat', 'nama_kota','nama_provinsi'
        ];

        $this->select('
            entitas.*,
            et.nama as nama_entitas_tipe,
            lk.nama as nama_kota,
            lp.nama as nama_provinsi
        ')
        ->join('entitas_tipe et', 'et.id=entitas.id_entitas_tipe', 'left')
        ->join('list_kota lk', 'lk.id=entitas.id_kota', 'left')
        ->join('list_provinsi lp', 'lp.id=lk.id_provinsi', 'left')
        ->where('entitas.deleted_at', NULL);

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

    // get by id
    public function get_by_id($id){
        $this->select('
            entitas.*,
            et.nama as nama_entitas_tipe,
            k.nama as nama_kota,
            p.nama as nama_provinsi
        ')
        ->join('entitas_tipe et', 'et.id=entitas.id_entitas_tipe', 'LEFT')
        ->join('list_kota k', 'k.id=entitas.id_kota', 'LEFT')
        ->join('list_provinsi p', 'p.id=k.id_provinsi', 'LEFT')
        ->where('entitas.id', $id);
        
        return $this->get()->getResult();
    }

}
