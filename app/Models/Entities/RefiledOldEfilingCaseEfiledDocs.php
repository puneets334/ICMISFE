<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefiledOldEfilingCaseEfiledDocs extends Entity
{
    protected $db;
    protected $table      = 'refiled_old_efiling_case_efiled_docs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'efiling_no', 'efiled_type', 'diary_no', 'allocated_to', 'created_at', 'created_by', 'updated_by_ip', 'display', 'create_modify', 'updated_on', 'updated_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}