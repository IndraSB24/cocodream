<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_karyawan_scheduling extends Model
{
    protected $table      = 'karyawan_scheduling';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_karyawan', 'id_kategori_day', 'start_time', 'end_time', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

}
