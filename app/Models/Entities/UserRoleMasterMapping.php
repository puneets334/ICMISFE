<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class UserRoleMasterMapping extends Entity
{
    protected $db;
    protected $table      = 'master.user_role_master_mapping';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'usercode', 'role_master_id', 'display', 'updated_by', 'updated_on', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}