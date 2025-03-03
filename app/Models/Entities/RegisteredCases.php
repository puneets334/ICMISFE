<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RegisteredCases extends Entity
{
    protected $db;
    protected $table      = 'registered_cases';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'lowerct_id', 'diary_no', 'fil_no', 'entuser', 'entdt', 'casetype_id', 'case_no', 'case_year', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}