<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SubMePer extends Entity
{
    protected $db;
    protected $table      = 'master.sub_me_per';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'sub_us_code', 'mn_me_per', 'sub_me_per', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}