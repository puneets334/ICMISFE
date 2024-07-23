<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class GodownUserAllocation extends Entity
{
    
    protected $table      = 'master.godown_user_allocation';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'usercode', 'casetype_id', 'caseyear', 'case_from', 'case_to', 'case_grp', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}