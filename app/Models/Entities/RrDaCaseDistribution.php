<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RrDaCaseDistribution extends Entity
{
    protected $db;
    protected $table      = 'master.rr_da_case_distribution';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'user_code', 'case_from', 'case_to', 'caseyear_from', 'caseyear_to', 'casehead', 'casetype', 'valid_from', 'valid_to', 'updated_by', 'update_on', 'display', 'create_modify', 'updated_on', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}