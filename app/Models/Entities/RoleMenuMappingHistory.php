<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RoleMenuMappingHistory extends Entity
{
    protected $db;
    protected $table      = 'master.role_menu_mapping_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'role_master_id', 'menu_id', 'display', 'updated_by', 'updated_on', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}