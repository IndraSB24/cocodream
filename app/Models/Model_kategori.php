<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_kategori extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = ['belongs_to', 'kode', 'nama', 'deskripsi', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // get by id
    public function get_by_id($id){
        $this->select('
            transaksi.*,
            r.kode as kode_transaksi,
            p.kode_pasien as kode_pasien,
            p.nama as nama_pasien,
            k1.nama as payment_method,
            k2.nama as payment_status
        ')
        ->join('registration r', 'r.id=transaksi.id_registration', 'LEFT')
        ->join('pasien p', 'p.id=transaksi.id_pasien', 'LEFT')
        ->join('kategori k1', 'k1.id=transaksi.id_payment_method', 'LEFT')
        ->join('kategori k2', 'k2.id=transaksi.id_payment_status', 'LEFT')
        ->where('transaksi.id', $id);
        
        return $this->get()->getResult();
    }

    public function countNoFiltered($kode)
    {
        $this->select('
            *
        ')
        ->where('kode', $kode)
        ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // ajax for  list item
    protected $main_column_searchable = [
        'kode', 'nama'
    ];
    protected $main_column_orderable = [
        'id', 'kode', 'nama'
    ];
    public function get_datatable_main($kode)
    {
        $request = service('request');

        $this->select('
            *
        ')
        ->where('kode', $kode)
        ->where('deleted_at', NULL);

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
        $result['count_filtered'] = $this->countNoFiltered($kode);
        $result['count_all'] = $this->countNoFiltered($kode);

        return $result;
    }

    // get by kode
    public function get_by_kode($kode){
        $this->select('
            *
        ')
        ->where('kode', $kode)
        ->where('deleted_at', null);
        
        return $this->get()->getResult();
    }

    // get item jenis
    public function get_item_jenis(){
        $this->select('
            *
        ')
        ->where('kode', 'item_jenis');
        
        return $this->get()->getResult();
    }

    // get item kategori
    public function get_item_kategori(){
        $this->select('
            *
        ')
        ->where('kode', 'item_kategori');
        
        return $this->get()->getResult();
    }

    // get payment status
    public function get_payment_status(){
        $this->select('
            *
        ')
        ->where('kode', 'payment_status');
        
        return $this->get()->getResult();
    }
    
    // get payment method
    public function get_payment_method(){
        $this->select('
            *
        ')
        ->where('kode', 'payment_method');
        
        return $this->get()->getResult();
    }

    // get transaction status
    public function get_registration_status(){
        $this->select('
            *
        ')
        ->where('kode', 'registration_status');
        
        return $this->get()->getResult();
    }

}
