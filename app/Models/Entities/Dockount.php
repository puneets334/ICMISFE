<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Dockount extends Entity
{
    
    protected $table      = 'master.dockount';
    // protected $primaryKey = 'dcode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['year', 'knt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
