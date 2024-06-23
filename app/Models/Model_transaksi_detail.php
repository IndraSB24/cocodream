<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_transaksi_detail extends Model
{
    protected $table      = 'transaksi_detail';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_transaksi', 'id_item', 'id_pricing', 'quantity', 'price', 'subtotal', 'created_by',
        'unit'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // get by id
    public function get_by_id($id){
        $this->select('
            *
        ')
        ->where('id', $id);
        
        return $this->get()->getResult();
    }

    // get by id transaksi
    public function get_by_id_transaksi($id_transaksi){
        $this->select('
            transaksi_detail.*,
            i.nama as nama_item,
            i.kode_item as kode_item,
            sd.nama as nama_satuan
        ')
        ->join('item i', 'i.id=transaksi_detail.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->where('transaksi_detail.id_transaksi', $id_transaksi)
        ->where('transaksi_detail.deleted_at', NULL);
        
        return $this->get()->getResult();
    }

    // get by id transaksi
    public function get_subtotal_by_id_transaksi($id_transaksi){
        return $this->selectSum('subtotal')
                    ->where('id_transaksi', $id_transaksi)
                    ->where('deleted_at', null)
                    ->get()
                    ->getRow()
                    ->subtotal;
    }
    

    // count no filtered
    public function countNoFiltered($id_transaksi)
    {
        $this->select('
            *
        ')
        ->where('id_transaksi', $id_transaksi)
        ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // ajax for registrasi detail
    protected $registrasi_detail_column_searchable = ['i.nama'];
    protected $registrasi_detail_column_orderable = ['id', 'i.nama', 'transaksi_detail.price', 'transaksi_detail.quantity'];
    public function get_datatable_registrasi_detail($id_transaksi)
    {
        $request = service('request');

        $this->select('
            transaksi_detail.*,
            i.nama as nama_item,
            i.kode_item as kode_item,
            sd.nama as nama_satuan
        ')
        ->join('item i', 'i.id=transaksi_detail.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->where('transaksi_detail.id_transaksi', $id_transaksi)
        ->where('transaksi_detail.deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
            foreach ($this->registrasi_detail_column_searchable as $item) {
                if ($i === 0) {
                    $this->groupStart(); // Open bracket for OR conditions
                    $this->like($item, $searchValue);
                } else {
                    $this->orLike($item, $searchValue);
                }
                if (count($this->registrasi_detail_column_searchable) - 1 == $i) {
                    $this->groupEnd(); // Close bracket for OR conditions
                }
                $i++;
            }
        }

        if ($request->getPost('order')) {
            $orderColumn = $this->registrasi_detail_column_orderable[$request->getPost('order')[0]['column']];
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
        $result['count_filtered'] = $this->countNoFiltered($id_transaksi);
        $result['count_all'] = $this->countNoFiltered($id_transaksi);

        return $result;
    }

    // count most sell product
    public function getMostProduct() {
        $today = date('Y-m-d');

        $this->select('
            i.nama as nama_item,
            i.image_filename as image_filename,
            SUM(transaksi_detail.quantity) as total_sell
        ')
        ->join('item i', 'i.id = transaksi_detail.id_item', 'LEFT')
        ->where('transaksi_detail.deleted_at', NULL)
        ->where('created_at =', $today)
        ->groupBy('i.nama')
        ->orderBy('total_sell', 'DESC')
        ->limit(5);;
    
        return $this->get()->getResult();
    }
    
}
