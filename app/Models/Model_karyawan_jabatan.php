<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_karyawan_jabatan extends Model
{
    protected $table      = 'karyawan_jabatan';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_karyawan', 'id_entitas', 'id_divisi', 'id_jabatan', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // get nakes per entitas
    public function get_nakes($id_entitas=null){
        $this->select('
            k.*,
            e.nama as entitas_name
        ')
        ->join('karyawan k', 'k.id=karyawan_jabatan.id_karyawan')
        ->join('entitas e', 'e.id=karyawan_jabatan.id_entitas')
        ->where('k.deleted_at', NULL)
        ->where('karyawan_jabatan.id_jabatan', 5)
        ->orWhere('karyawan_jabatan.id_jabatan', 6)
        ->where('karyawan_jabatan.deleted_at', NULL);

        if($id_entitas != null){
            $this->where('karyawan_jabatan.id_entitas', $id_entitas);
        }
        
        return $this->get()->getResult();
    }

}
