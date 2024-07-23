<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FasterCases extends Entity
{
    
    protected $table      = 'faster_cases';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'next_dt', 'created_on', 'created_by', 'last_step_id', 'is_deleted', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}