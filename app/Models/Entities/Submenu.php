<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SubMenu extends Entity
{
    protected $db;
    protected $table      = 'master.submenu';
    protected $primaryKey = 'su_menu_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['su_menu_id', 'id', 'sub_mn_nm', 'o_d', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}