<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_transaksi extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_registration', 'id_pasien', 'transaction_date', 'total_amount', 'id_payment_method', 
        'payment_status', 'is_online_shop', 'is_from_registration', 'created_by', 'id_entitas', 
        'no_invoice', 'id_distribution_channel'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // count all not deleted row
    public function countNoFiltered()
    {
        $this->select('
                *
            ')
            ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // get all
    public function get_all(){
        $this->select('
            transaksi.*,
            r.kode as kode_transaksi,
            p.kode_pasien as kode_pasien,
            p.nama as nama_pasien,
            k1.nama as payment_method
        ')
        ->join('registration r', 'r.id=transaksi.id_registration', 'LEFT')
        ->join('pasien p', 'p.id=transaksi.id_pasien', 'LEFT')
        ->join('kategori k1', 'k1.id=transaksi.id_payment_method', 'LEFT')
        ->where('transaksi.deleted_at', NULL);
        
        return $this->get()->getResult();
    }

    // get by id
    public function get_by_id($id){
        $this->select('
            transaksi.*,
            r.kode as kode_transaksi,
            p.kode_pasien as kode_pasien,
            p.nama as nama_pasien,
            k1.nama as payment_method,
            e.nama as entitas_name,
            e.alamat as entitas_address,
            e.phone as entitas_phone
        ')
        ->join('registration r', 'r.id=transaksi.id_registration', 'LEFT')
        ->join('pasien p', 'p.id=transaksi.id_pasien', 'LEFT')
        ->join('kategori k1', 'k1.id=transaksi.id_payment_method', 'LEFT')
        ->join('entitas e', 'e.id=transaksi.id_entitas', 'LEFT')
        ->where('transaksi.id', $id);
        
        return $this->get()->getResult();
    }

    // get by id
    public function get_by_id_registrasi($idRegistrasi){
        $this->select('
            transaksi.*,
            r.kode as kode_transaksi,
            p.kode_pasien as kode_pasien,
            p.nama as nama_pasien,
            k1.nama as payment_method,
            e.nama as entitas_name,
            e.alamat as entitas_address,
            e.phone as entitas_phone
        ')
        ->join('registration r', 'r.id=transaksi.id_registration', 'LEFT')
        ->join('pasien p', 'p.id=transaksi.id_pasien', 'LEFT')
        ->join('kategori k1', 'k1.id=transaksi.id_payment_method', 'LEFT')
        ->join('entitas e', 'e.id=transaksi.id_entitas', 'LEFT')
        ->where('transaksi.id_registration', $idRegistrasi);
        
        return $this->get()->getResult();
    }

    // ajax for  list item
    protected $main_column_searchable = [
        'transaksi.id'
    ];
    protected $main_column_orderable = [
        'transaksi.id', 'transaksi.id'
    ];
    public function get_datatable_main()
    {
        $request = service('request');

        $this->select('
            transaksi.*,
            k1.nama as payment_method,
            SUM(td.subtotal) as total_nominal
        ')
        ->join('kategori k1', 'k1.id=transaksi.id_payment_method', 'LEFT')
        ->join('transaksi_detail td', 'td.id_transaksi=transaksi.id', 'LEFT')
        ->groupBy('transaksi.id')
        ->where('transaksi.deleted_at', NULL)
        ->orderBy('transaksi.id', 'DESC');

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

    // insert with db transaction
    public function insertWithReturnId($data) {
        $this->db->transBegin();

        $this->db->table('transaksi')->insert($data);

        $transactionId = $this->db->insertID();

        $this->db->transCommit();

        return $transactionId;
    }

    // laporan penjualan
    public function get_datatable_laporan_penjualan()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'transaksi.nama'
        ];
        $column_orderable = [
            'transaksi.id', 'i.nama'
        ];

        // filter
        if ($request->getPost('filterDateFrom')) {
            $this->where('transaksi.transaction_date >=', $request->getPost('filterDateFrom').' 00:00:00');
        }

        if ($request->getPost('filterDateUntil')) {
            $this->where('transaksi.transaction_date <=', $request->getPost('filterDateUntil').' 23:59:59');
        }

        $this->select('
            transaksi.*,
            pm.name as payment_method,
            SUM(td.subtotal) as total_nominal
        ')
        ->join('payment_method pm', 'pm.id=transaksi.id_payment_method', 'LEFT')
        ->join('transaksi_detail td', 'td.id_transaksi=transaksi.id', 'LEFT')
        ->groupBy('transaksi.id')
        ->where('transaksi.deleted_at', NULL)
        ->orderBy('transaksi.id', 'DESC');

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

}
