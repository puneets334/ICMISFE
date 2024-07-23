<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Userdept extends Entity
{
    protected $db;
    protected $table      = 'userdept';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'dept_name', 'uside_flag', 'display', 'entuser', 'entdt', 'upuser', 'updt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}