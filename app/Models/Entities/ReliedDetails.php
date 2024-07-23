<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ReliedDetails extends Entity
{
    protected $db;
    protected $table      = 'relied_details';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['relied_id', 'lowerct_id', 'relied_court', 'relied_case_type', 'relied_case_no', 'relied_case_year', 'relied_state', 'relied_district', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}