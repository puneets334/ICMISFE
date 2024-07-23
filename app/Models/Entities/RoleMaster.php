<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RoleMaster extends Entity
{
    protected $db;
    protected $table      = 'master.role_master';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'role_desc', 'display', 'updated_by', 'updated_on', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}