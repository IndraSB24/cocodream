<?php

namespace App\Models;
use CodeIgniter\Model;

class Model_roles extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama', 'deskripsi', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // get by username
    public function getRoles(){
        $this->select('
            *
        ')
        ->where('id !=', '1');
        
        return $this->get()->getResult();
    }

}
