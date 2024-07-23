<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SensitiveCases extends Entity
{
    protected $db;
    protected $table      = 'master.sensitive_cases';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'reason', 'display', 'updated_by', 'updated_on', 'updated_from_ip', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}