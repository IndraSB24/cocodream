<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_item_restock extends Model
{
    protected $table      = 'item_restock';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_item', 'quantity', 'restock_date', 'id_entitas', 'created_by',
        'unit', 'type', 'price', 'code'
    ];

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

    // get by id
    public function get_by_id($id){
        $this->select('
            *
        ')
        ->where('id', $id);
        
        return $this->get()->getResult();
    }

    // get
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            
        ];
        $column_orderable = [
            'item_restock.id'
        ];

        $this->select('
            item_restock.*,
            i.kode_item as item_code,
            i.nama as item_name
        ')
        ->join('item i', 'i.id=item_restock.id_item', 'LEFT')
        ->where('item_restock.deleted_at', NULL);

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

    // insert with db transaction
    public function insertWithReturnId($data) {
        $this->db->transBegin();

        $this->db->table($this->table)->insert($data);

        $transactionId = $this->db->insertID();

        $this->db->transCommit();

        return $transactionId;
    }

}
