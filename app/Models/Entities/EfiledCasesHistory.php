<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EfiledCasesHistory extends Entity
{
    
    protected $table      = 'efiled_cases_history';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'efiling_no', 'efiled_type', 'diary_no', 'created_at', 'created_by', 'display', 'deleted_at', 'deleted_by', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}