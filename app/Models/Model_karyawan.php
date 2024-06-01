<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_karyawan extends Model
{
    protected $table      = 'karyawan';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = ['no_induk', 'nama', 'hp', 'id_jabatan', 'id_divisi', 'id_entitas', 'id_user', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // ajax for datatable list_pasien
    protected $column_searchable = ['no_induk'];
    protected $column_orderable = ['id', 'no_induk'];
    public function getDatatables()
    {
        $request = service('request');

        // filter set
        if ($request->getPost('filter_divisi')) {
            $this->where('karyawan.id_divisi', $request->getPost('filter_divisi'));
        }
        if ($request->getPost('filter_entitas')) {
            $this->where('karyawan.id_entitas', $request->getPost('filter_entitas'));
        }

        $this->select('
                karyawan.*,
                j.nama as nama_jabatan,
                d.nama as nama_divisi,
                e.nama as nama_entitas
            ')
            ->join('jabatan j', 'j.id=karyawan.id_jabatan', 'left')
            ->join('divisi d', 'd.id=karyawan.id_divisi', 'left')
            ->join('entitas e', 'e.id=karyawan.id_entitas', 'left')
            ->where('karyawan.deleted_at', NULL);

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

        $this->select('
                *
            ')
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
        $this->select('
                *
            ')
            ->where('deleted_at', NULL);

        return $this->countAllResults();
    }

    // ajax for  list schedule
    public function get_datatable_scheduling()
    {
        $request = service('request');

        // set searchable and orderable
        $column_searchable = [
            'karyawan.no_induk', 'karyawan.nama'
        ];
        $column_orderable = [
            'karyawan.id', 'karyawan.no_induk', 'karyawan.nama'
        ];

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
        ->where('karyawan.deleted_at', NULL);

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
