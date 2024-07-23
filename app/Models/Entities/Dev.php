<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Dev extends Entity
{
    
    protected $table      = 'master.dev';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'aor_code', 'cname','cfname', 'regdate', 'eino','create_modify','updated_on' ,'updated_by','updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
