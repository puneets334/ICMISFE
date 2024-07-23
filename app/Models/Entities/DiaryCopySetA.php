<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DiaryCopySetA extends Entity
{
    
    protected $table      = 'diary_copy_set_a';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'id', 'diary_no','copy_set','create_modify','updated_on' ,'updated_by','updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
