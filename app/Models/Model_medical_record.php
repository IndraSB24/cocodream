<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_medical_record extends Model
{
    protected $table      = 'medical_record';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'no_mr', 'id_registration', 'id_transaction', 'created_by',
        'id_entitas', 'id_patient', 'record_date', 'notes'
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

    // get
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'cash_drawer.nama'
        ];
        $column_orderable = [
            'item_transaksi_stock.id', 'i.nama'
        ];

        $this->select('
            item_transaksi_stock.*,
            i.kode_item as kode_item,
            i.nama as nama_item,
            sd.nama as nama_satuan,
            e.nama as nama_entitas
        ')
        ->join('item i', 'i.id=item_transaksi_stock.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->join('entitas e', 'e.id=item_transaksi_stock.id_entitas', 'LEFT')
        ->where('item_transaksi_stock.deleted_at', NULL);

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
            *
        ')
        ->where('id', $id);
        
        return $this->get()->getResult();
    }

    // get by id patient
    public function get_by_id_patient(){
        $request = service('request');
        // filter from date
        if ( $request->getPost('filter_from_date') ){
            $this->where('medical_record.record_date >=', $request->getPost('filter_from_date'));
        }

        // filter to date
        if ( $request->getPost('filter_to_date') ){
            $this->where('medical_record.record_date <=', $request->getPost('filter_to_date'));
        }

        $this->select('
            medical_record.*,
            mrd.id_item as item_id,
            mrd.item_quantity as item_quantity,
            i.nama as item_name,
            sd.kode as item_satuan,
            p.nama as patient_name,
            p.kode_pasien as patient_code
        ')
        ->join('medical_record_detail mrd', 'mrd.id_mr=medical_record.id')
        ->join('item i', 'i.id=mrd.id_item', 'LEFT')
        ->join('satuan_dasar sd', 'sd.id=i.id_satuan', 'LEFT')
        ->join('pasien p', 'p.id=medical_record.id_patient', 'LEFT')
        ->where('medical_record.id_patient', $request->getPost('filter_patient'));
        
        return $this->get()->getResultArray();
    }

    // insert with db transaction
    public function insertWithReturnId($data) {
        $this->db->transBegin();

        $this->db->table('medical_record')->insert($data);

        $transactionId = $this->db->insertID();

        $this->db->transCommit();

        return $transactionId;
    }

}
