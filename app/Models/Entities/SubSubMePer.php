<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SubSubMePer extends Entity
{
    protected $db;
    protected $table      = 'master.sub_sub_me_per';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'sub_sub_us_code', 'sub_me_per_id', 'sub_sub_menu', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}