<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MasterFixedfor extends Entity
{
    protected $db;
    protected $table      = 'master.master_fixedfor';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'fixed_for_desc', 'display', 'displayat', 'oldcode', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}