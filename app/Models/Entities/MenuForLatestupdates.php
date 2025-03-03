<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MenuForLatestupdates extends Entity
{
    protected $db;
    protected $table      = 'master.menu_for_latestupdates';

    protected $primaryKey = 'mno';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['mno', 'menu_name', 'folder_name', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
