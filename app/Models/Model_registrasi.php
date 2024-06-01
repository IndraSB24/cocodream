<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_registrasi extends Model
{
    protected $table      = 'registration';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_entitas', 'id_pasien', 'plan_date', 'actual_date', 'id_staff', 'status', 'created_by', 'kode'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // ajax for datatable
    protected $column_searchable = [
        'registration.id', 'e.nama', 'p.kode_pasien', 'p.nama', 'k.nama'
    ];
    protected $column_orderable = [
        'registration.id', 'registration.id', 'e.nama', 'p.kode_pasien', 'p.nama', 'k.nama'
    ];
    public function getDatatables()
    {
        $request = service('request');

        $this->select('
            registration.*,
            p.kode_pasien as kode_pasien,
            p.nama as nama_pasien,
            p.phone as phone_pasien,
            k.nama as nama_staff,
            e.nama as nama_entitas
        ')
        ->join('pasien p', 'p.id=registration.id_pasien', 'LEFT')
        ->join('karyawan k', 'k.id=registration.id_staff', 'LEFT')
        ->join('entitas e', 'e.id=registration.id_entitas', 'LEFT')
        ->where('registration.deleted_at', NULL);

        if ($request->getPost('search')['value']) {
            $searchValue = $request->getPost('search')['value'];
            $i = 0;
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
            registration.*,
            p.kode_pasien as kode_pasien,
            p.nama as nama_pasien,
            p.phone as phone_pasien,
            k.nama as nama_staff,
            e.nama as nama_entitas
        ')
        ->join('pasien p', 'p.id=registration.id_pasien', 'LEFT')
        ->join('karyawan k', 'k.id=registration.id_staff', 'LEFT')
        ->join('entitas e', 'e.id=registration.id_entitas', 'LEFT')
        ->where('registration.deleted_at', NULL);

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

    // get by id
    public function get_by_id($id){
        $this->select('
            registration.*,
            p.nama as nama_pasien,
            p.kode_pasien as kode_pasien,
            k.nama as nama_karyawan
        ')
        ->where('registration.id', $id)
        ->join('pasien p', 'p.id=registration.id_pasien', 'LEFT')
        ->join('karyawan k', 'k.id=registration.id_staff', 'LEFT');
        
        return $this->get()->getResult();
    }

    // insert with db transaction
    public function insertWithReturnId($data) {
        $this->db->transBegin();

        $this->db->table('registration')->insert($data);

        $insertedId = $this->db->insertID();

        $this->db->transCommit();

        return $insertedId;
    }

}
