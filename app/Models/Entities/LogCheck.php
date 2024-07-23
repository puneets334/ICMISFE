<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LogCheck extends Entity
{
    protected $db;
    protected $table      = 'log_check';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usercode', 'username', 'logging', 'addr', 'id_session', 'mac_addr', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}