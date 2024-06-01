<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_item_detail extends Model
{
    protected $table      = 'item_detail';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_item_utama', 'id_item', 'jumlah'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // get by id
    public function get_by_id($id){
        $this->select('
            item_detail.*,
            i.kode_item as kode_item,
            i.nama as nama_item,
            sd.nama as nama_satuan
        ')
        ->join('item i', 'i.id=item_detail.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->where('i.id', $id);
        
        return $this->get()->getResult();
    }

    // count all not deleted row
    public function countNoFiltered()
    {
        $this->select('
                *
            ')
            ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // ajax for  list item
    protected $main_column_searchable = ['i.nama.'];
    protected $main_column_orderable = ['id', 'i.nama'];
    public function get_datatable_main($id_item_utama)
    {
        $request = service('request');

        $this->select('
            item_detail.*,
            i.kode_item as kode_item,
            i.nama as nama_item,
            sd.nama as nama_satuan
        ')
        ->join('item i', 'i.id=item_detail.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->where('item_detail.deleted_at', NULL)
        ->where('item_detail.id_item_utama', $id_item_utama);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
            foreach ($this->main_column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); 
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($this->main_column_searchable) - 1 == $i) {
                    $this->groupEnd(); 
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $this->main_column_orderable[$request->getPost('order')[0]['column']];
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

    // get by id main item
    public function get_by_id_main_item($id_main_item){
        $this->select('
            *
        ')
        ->where('id_item_utama', $id_main_item);
        
        return $this->get()->getResult();
    }

}
