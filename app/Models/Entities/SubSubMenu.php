<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SubSubMenu extends Entity
{
    protected $db;
    protected $table      = 'master.sub_sub_menu';
    protected $primaryKey = 'su_su_menu_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['su_su_menu_id', 'su_menu_id', 'sub_sub_mn_nm', 'url', 'display', 'purpose', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}