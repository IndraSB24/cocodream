<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_item_stock_management extends Model
{
    protected $table      = 'item_stock_management';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_item', 'code_production', 'batch_number', 'production_date', 'expiry_date', 'created_by'
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

    // ajax for  list stock management
    public function get_datatable_main()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'item_stock_management.batch_number'
        ];
        $column_orderable = [
            'item_stock_management.id', 'item_stock_management.batch_number'
        ];

        $this->select('
            item_stock_management.*,
            SUM(ir.jumlah) as jumlah 
        ')
        ->join('item_restock ir', 'ir.id_item_batch=item_stock_management.id', 'LEFT')
        ->groupBy('item_stock_management.id')
        ->where('item_stock_management.deleted_at', NULL);

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
    public function get_batch_data($payload){
        $this->select('
            item_stock_management.*,
            i.nama as item_name
        ')
        ->join('item i', 'i.id=item_stock_management.id_item', 'LEFT')
        ->where('item_stock_management.deleted_at', NULL);
        
        return $this->get()->getResult();
    }

    // get by id
    public function get_by_id($id){
        $this->select('
                karyawan.*,
                j.nama as nama_jabatan,
                d.nama as nama_divisi,
                e.nama as nama_entitas
            ')
            ->join('jabatan j', 'j.id=karyawan.id_jabatan', 'left')
            ->join('divisi d', 'd.id=karyawan.id_divisi', 'left')
            ->join('entitas e', 'e.id=karyawan.id_entitas', 'left')
            ->where('karyawan.deleted_at', NULL)
        ->where('karyawan.id', $id);
        
        return $this->get()->getResult();
    }

    public function get_schedule_by_karyawan_id($id_karyawan){
        $this->select('
            karyawan.*,
            d1.start_time AS d1_start_time,
            d1.end_time AS d1_end_time,
            d2.start_time AS d2_start_time,
            d2.end_time AS d2_end_time,
            d3.start_time AS d3_start_time,
            d3.end_time AS d3_end_time,
            d4.start_time AS d4_start_time,
            d4.end_time AS d4_end_time,
            d5.start_time AS d5_start_time,
            d5.end_time AS d5_end_time,
            d6.start_time AS d6_start_time,
            d6.end_time AS d6_end_time,
            d7.start_time AS d7_start_time,
            d7.end_time AS d7_end_time
        ')
        ->join('karyawan_scheduling d1', 'd1.id_karyawan=karyawan.id AND d1.id_kategori_day=28', 'LEFT')
        ->join('karyawan_scheduling d2', 'd2.id_karyawan=karyawan.id AND d2.id_kategori_day=29', 'LEFT')
        ->join('karyawan_scheduling d3', 'd3.id_karyawan=karyawan.id AND d3.id_kategori_day=30', 'LEFT')
        ->join('karyawan_scheduling d4', 'd4.id_karyawan=karyawan.id AND d4.id_kategori_day=31', 'LEFT')
        ->join('karyawan_scheduling d5', 'd5.id_karyawan=karyawan.id AND d5.id_kategori_day=32', 'LEFT')
        ->join('karyawan_scheduling d6', 'd6.id_karyawan=karyawan.id AND d6.id_kategori_day=33', 'LEFT')
        ->join('karyawan_scheduling d7', 'd7.id_karyawan=karyawan.id AND d7.id_kategori_day=34', 'LEFT')
        ->groupBy('karyawan.id')
        ->where('karyawan.id', $id_karyawan);

        return $this->get()->getResult();
    }

}
