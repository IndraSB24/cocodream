<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_pasien extends Model
{
    protected $table      = 'pasien';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'kode_pasien', 'nama', 'tanggal_lahir', 'alamat', 'phone', 'id_kota', 'created_by', 'tipe_member',
        'no_mr'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function get_list_pasien_raw() {
        $sql = "
            SELECT 
                *
            FROM pasien
            WHERE deleted_at IS NULL
            ORDER BY nama ASC;
        ";
        
        $query = $this->db->query($sql);
        return $query->getResult();
    }  

    // ajax for datatable list_pasien
    protected $column_searchable = ['pasien.kode_pasien', 'pasien.nama', 'pasien.tanggal_lahir', 'pasien.alamat', 'pasien.phone'];
    protected $column_orderable = ['pasien.id', 'pasien.kode_pasien', 'pasien.nama', 'pasien.tanggal_lahir', 'pasien.alamat', 'pasien.phone'];
    public function getDatatables()
    {
        $request = service('request');

        // filter set
        if ($request->getPost('filter_kota')) {
            $this->where('pasien.id_kota', $request->getPost('filter_kota'));
        }
        // if ($request->getPost('filter_entitas')) {
        //     $this->where('karyawan.id_entitas', $request->getPost('filter_entitas'));
        // }

        $this->select('
            pasien.*,
            k.nama as nama_kota
        ')
        ->join('list_kota k', 'k.id=pasien.id_kota', 'LEFT')
        ->where('pasien.id !=', 0)
        ->where('pasien.deleted_at', NULL)
        ->orderBy('pasien.id', 'DESC');

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
            pasien.*,
            k.nama as nama_kota
        ')
        ->join('list_kota k', 'k.id=pasien.id_kota', 'LEFT')
        ->where('pasien.id !=', 0)
        ->where('pasien.deleted_at', NULL);

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
        $this->select('*')
            ->where('id !=', 0)
            ->where('deleted_at', null);

        return $this->countAllResults();
    }

    // regex search
    public function search_pasien($keyword)
    {
        $this->select('
            *
        ')
        ->like('nama', $keyword, 'both')
        ->orLike('kode_pasien', $keyword, 'both')
        ->where('deleted_at', NULL);
        
        return $this->get()->getResult();
    }

    // get by id
    public function get_by_id($id){
        $this->select('
            pasien.*,
            k.nama as nama_kota
        ')
        ->join('list_kota k', 'k.id=pasien.id_kota', 'LEFT')
        ->where('pasien.id', $id);
        
        return $this->get()->getResult();
    }

    // insert with db transaction
    public function insertWithReturnId($data) {
        $this->db->transBegin();

        $this->db->table('pasien')->insert($data);

        $transactionId = $this->db->insertID();

        $this->db->transCommit();

        return $transactionId;
    }

}
