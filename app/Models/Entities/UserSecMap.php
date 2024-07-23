<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class UserSecMap extends Entity
{
    protected $db;
    protected $table      = 'master.user_sec_map';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'empid', 'usec', 'display', 'updated_on', 'updated_by', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}